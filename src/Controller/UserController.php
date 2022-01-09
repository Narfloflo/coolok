<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

#[Route('', name:'user_')]
class UserController extends AbstractController
{
    private $em;
    private $hasher;
    private $userRepository;

    public function __construct(EntityManagerInterface $em, UserPasswordHasherInterface $hasher, UserRepository $userRepository)
    {
        $this->em = $em;
        $this->hasher = $hasher;
        $this->userRepository = $userRepository;
    }

    // #[Route('/connexion', name: 'login')]
    // public function login(): Response
    // {
    //     return $this->render('user/login.html.twig', [
    //         'controller_name' => 'UserController',
    //     ]);
    // }

    #[Route('/inscription', name: 'register')]
    public function register(Request $request): Response
    {
        if($this->getUser()){
            return $this->disallowAccess();
        }

        $user = new User();
        $form = $this->createForm(UserType::class, $user);
        
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $hashed = $this->hasher->hashPassword($user, $user->getPlainPassword());
            $user->setPassword($hashed);
            
            $this->em->persist($user);
            $this->em->flush();

            $this->addFlash('notice', 'Votre compte à bien été créé, vous pouvez dés à présent vous connecter');
            return $this->redirectToRoute('user_login');
        }

        return $this->render('user/register.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/compte/{id}', name: 'profil', requirements: ['id' => '\d+'])]
    public function compte($id): Response
    {
        $profil = $this->userRepository->find($id);
        return $this->render('user/index.html.twig', [
            'user' => $profil,
        ]);
    }

    #[Route('/creation_logement', name: 'AddFlat')]
    public function AddFlat(): Response
    {
        return $this->render('user/AddFlat.html.twig', [
            'controller_name' => 'UserController',
        ]);
    }


    #[Route('/profil/{id}', name: 'view_Profil', requirements: ['id' => '\d+'])]
    public function view_Profil($id, User $user): Response
    {
        $view_Profil = $this->userRepository->find($id);

        $birthday = $view_Profil->getBirthday()->getTimestamp();
        $userAge = round((time() - $birthday) / 31556952);
        
        return $this->render('user/view_user.html.twig', [
            'userAge' => $userAge,
            'user' => $view_Profil,
        ]);
    }

    private function disallowAccess(): Response
    {
        $this->addFlash('info', 'Vous êtes déjà connecté, déconnectez vous pour changer de compte');
        return $this->redirectToRoute('main_index');
    }
}
