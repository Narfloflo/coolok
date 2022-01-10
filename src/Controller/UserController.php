<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use App\Repository\FlatRepository;
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
    private $flatRepository;

    public function __construct(EntityManagerInterface $em, UserPasswordHasherInterface $hasher, UserRepository $userRepository, FlatRepository $flatRepository)
    {
        $this->em = $em;
        $this->hasher = $hasher;
        $this->userRepository = $userRepository;
        $this->flatRepository = $flatRepository;

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

    #[Route('/colocataires', name: 'coloc')]
    public function showAllUser(): Response 
    {
        $allNewUser = $this->userRepository->findBy(
            ['available' => 1],
            ['id' => 'DESC'],
        );
        // dd(count($allNewUser));
        $allUserAge = [];
        for($i = 0; $i < count($allNewUser); $i++){
            $birthday = $allNewUser[$i]->getBirthday()->getTimestamp();
            $userAge = round((time() - $birthday) / 31556952);

            $allUserAge[] = $userAge;
        }

        return $this->render('user/all_users.html.twig', [
            'allUser' => $allNewUser,
            'allUserAge' => $allUserAge,
        ]);
    }


    #[Route('/compte/{id}', name: 'profil', requirements: ['id' => '\d+'])]
    public function compte($id): Response
    {
        // Allow access if User id = User connected
        $profil = $this->userRepository->find($id);
        if ($profil !== $this->getUser()) {
            throw $this->createAccessDeniedException();
        }

        return $this->render('user/index.html.twig', [
            'user' => $profil,
        ]);
    }

    #[Route('/compte/{id}/favoris', name: 'favorites', requirements: ['id' => '\d+'])]
    public function showFavorites($id) : Response
    {
        $profil = $this->userRepository->find($id);
        $favoritesUser = $profil->getFavoriteUser();
        $favoritesFlat = $profil->getFavoriteFlat();

        $favoritesUserAge = [];
        for($i = 0; $i < count($favoritesUser); $i++){
            $birthday = $favoritesUser[$i]->getBirthday()->getTimestamp();
            $userAge = round((time() - $birthday) / 31556952);

            $favoritesUserAge[] = $userAge;
        }

        return $this->render('user/favorites.html.twig', [
            'favoritesUser' => $favoritesUser,
            'favoritesUserAge' => $favoritesUserAge,
            'favoritesFlat' => $favoritesFlat,
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
        
        if($this->getUser()){
            $user = $this->getUser();
        $favoritesUser = $user->getFavoriteUser();
        if($favoritesUser->contains($view_Profil)){
            $isFav = true;
        }else{
            $isFav = false;
        }
        }else{
            $isFav = false;
        }
        return $this->render('user/view_user.html.twig', [
            'userAge' => $userAge,
            'user' => $view_Profil,
            'isFav' => $isFav,
        ]);
    }

    #[Route('/profil/{id}/success', name: 'favorite', requirements: ['id' => '\d+'])]
    public function favoriteUser($id) : Response
    {
        $profilToAdd = $this->userRepository->find($id);
        if(!$this->getUser()){
            return $this->redirectToRoute('user_login');
        }
        $user = $this->getUser();
        $favoritesuser = $user->getFavoriteUser();

        if($favoritesuser->contains($profilToAdd)){
            $user->removeFavoriteUser($profilToAdd);
            $this->addFlash('notice', 'Ce profil a été supprimé de vos favoris');
        }else{
            $user->addFavoriteUser($profilToAdd);
            $this->addFlash('notice', 'Ce profil a été ajouté à vos favoris');
        }
        $this->em->persist($user);
        $this->em->flush();

        return $this->redirectToRoute('user_view_Profil', ['id' => $id]);
    }

    private function disallowAccess(): Response
    {
        $this->addFlash('info', 'Vous êtes déjà connecté, déconnectez vous pour changer de compte');
        return $this->redirectToRoute('main_index');
    }
}
