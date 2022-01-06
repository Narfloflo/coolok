<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
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

    public function __construct(EntityManagerInterface $em, UserPasswordHasherInterface $hasher)
    {
        $this->em = $em;
        $this->hasher = $hasher;
    }

    #[Route('/connexion', name: 'login')]
    public function login(): Response
    {
        return $this->render('user/login.html.twig', [
            'controller_name' => 'UserController',
        ]);
    }

    #[Route('/inscription', name: 'register')]
    public function register(Request $request): Response
    {
        // if($this->getUser()){
        //     return $this->disallowAccess();
        // }

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

    #[Route('/profil', name: 'profil')]
    public function profil(): Response
    {
        return $this->render('user/index.html.twig', [
            'controller_name' => 'UserController',
        ]);
    }

    #[Route('/creation_logement', name: 'createFlat')]
    public function createFlat(): Response
    {
        return $this->render('user/createFlat.html.twig', [
            'controller_name' => 'UserController',
        ]);
    }

    #[Route('/voir_profil', name: 'viewProfil')]
    public function viewProfil(): Response
    {
        return $this->render('user/view_user.html.twig', [
            'controller_name' => 'UserController',
        ]);
    }
}
