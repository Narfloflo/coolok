<?php

namespace App\Controller;

use App\Entity\Flat;
use App\Entity\User;
use App\Form\UserType;
use App\Form\AddFlatType;
use App\Form\ContactUserType;
use App\Service\UserService;
use App\Form\EditAccountType;
use App\Repository\FlatRepository;
use App\Repository\UserRepository;
use App\Service\FileUploaderService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
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
    private $userService;

    public function __construct(
        EntityManagerInterface $em,
        UserPasswordHasherInterface $hasher,
        UserRepository $userRepository,
        UserService $userService,
    ){
        $this->em = $em;
        $this->hasher = $hasher;
        $this->userRepository = $userRepository;
        $this->userService = $userService;
        // $this->fileUploader = $fileUploader;
    }

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
        $allUserAge = $this->userService->calculAges($allNewUser);

        return $this->render('user/all_users.html.twig', [
            'allUser' => $allNewUser,
            'allUserAge' => $allUserAge,
        ]);
    }


    #[Route('/compte', name: 'profil')]
    public function compte(): Response
    {
        // Allow access if User id = User connected
        if (!$this->getUser()) {
            throw $this->createAccessDeniedException();
        }

        if($this->getUser()->getFirstname() === null){
            return $this->redirectToRoute('user_edit');
        }else{
            $userAge = $this->userService->calculAge($this->getUser());
            return $this->render('user/index.html.twig', [
                'user' => $this->getUser(),
                'userAge' => $userAge,
            ]);
        }
    }

    #[Route('/compte/edit', name: 'edit')]
    public function edit(Request $request, FileUploaderService $fileUploader) : Response
    {
        if (!$this->getUser()) {
            throw $this->createAccessDeniedException();
        }
        $user = $this->getUser();

        if($user->getPicture() != null){
            $hadPicture = false;
        }else{
            $hadPicture = 'is_null($builder->getData()->getId())';
        }

        $form = $this->createForm(EditAccountType::class, $user, [
            'picture' => $hadPicture,
        ]);

        $form->handleRequest($request);
        
        if($form->isSubmitted() && $form->isValid()){
            // Upload picture file via service
            $pictureFile = $form->get('picture')->getData();
            if ($pictureFile) {
            $pictureFileName = $fileUploader->upload($pictureFile);
            $user->setPicture($pictureFileName);
            }

            $this->em->persist($user);
            $this->em->flush();

            $message = sprintf('Votre profil est désormais à jour');
            $this->addFlash('notice', $message);

            return $this->redirectToRoute('user_profil');
        }

        return $this->render('user/edit_account.html.twig', [
            'form' => $form->createView(),
            'profil' => $user,
        ]);
    }

    #[Route('/compte/favoris', name: 'favorites')]
    public function showFavorites() : Response
    {
        $profil = $this->getUser();
        $favoritesUser = $profil->getFavoriteUser();
        $favoritesFlat = $profil->getFavoriteFlat();

        $favoritesUserAge = $this->userService->calculAges($favoritesUser);

        return $this->render('user/favorites.html.twig', [
            'favoritesUser' => $favoritesUser,
            'favoritesUserAge' => $favoritesUserAge,
            'favoritesFlat' => $favoritesFlat,
        ]);
    }


    #[Route('/compte/desactivate', name: 'desactivation')]
    public function desactivation() : Response
    {
        $profil = $this->getUser();
        $profil->setAvailable(false);
        
        $this->em->persist($profil);
        $this->em->flush();

        $message = sprintf('Votre profil est désormais désactivé');
        $this->addFlash('notice', $message);

        return $this->redirectToRoute('user_profil');
    }

    #[Route('/compte/suppression', name: 'delete')]
    public function delete() : Response
    {
        if (!$this->getUser()) {
            throw $this->createAccessDeniedException();
        }

        $profil = $this->getUser();
        return $this->render('user/delete.html.twig', [
            'profil' => $profil,
        ]);
    }

    #[Route('/compte/suppression/confirmation', name: 'delete_confirmation')]
    public function deleteSuccess() : Response
    {
        if (!$this->getUser()) {
            throw $this->createAccessDeniedException();
        }

        $profil = $this->getUser();
        $profil->setAvailable(false);
        $profil->setDeleted(true);
        
        $this->em->persist($profil);
        $this->em->flush();

        $message = sprintf('Votre compte est bien supprimé');
        $this->addFlash('notice', $message);

        return $this->redirectToRoute('app_logout');
    }

    #[Route('/compte/activate', name: 'activation')]
    public function activation() : Response
    {
        $profil = $this->getUser();
        $profil->setAvailable(true);
        
        $this->em->persist($profil);
        $this->em->flush();

        $message = sprintf('Votre profil est désormais activé');
        $this->addFlash('notice', $message);

        return $this->redirectToRoute('user_profil');
    }


    #[Route('/creation_logement', name: 'AddFlat')]
    #[Route('/edit_logement/{id}', name: 'editFlat', requirements: ['id' => '\d+'])]

    public function AddFlat(Request $request, Flat $flat = null): Response
    {
        if($flat){
            $isNew = false;
        }else{
            $flat = new Flat();
            $flat->setOwner($this->getUser());
            $isNew = true;
        }
        $form = $this->createForm(AddFlatType::class, $flat);
        
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $this->mediaService->handleEvent($flat);
            $this->em->persist($flat);
            $this->em->flush();

            $message = sprintf('Votre logement à bien été %s', $isNew ? 'créé' : 'modifié');
            $this->addFlash('notice', $message);
            return $this->redirectToRoute('flat_show', [
                'id' => $flat->getId(),
            ]);
        }

        return $this->render('user/AddFlat.html.twig', [
        'form' => $form->createView(),
        'isNew' => $isNew
        ]);
    }

    #[Route('/profil/{id}', name: 'view_Profil', requirements: ['id' => '\d+'])]
    
    public function view_Profil($id, User $user, MailerInterface $mailer, Request $request): Response
    {
        $view_Profil = $this->userRepository->find($id);
        $userAge = $this->userService->calculAge($view_Profil);
        
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
        $mailSender = $user->getEmail();
        $mailReceiver = $view_Profil->getEmail();
       
        $form = $this->createForm(ContactUserType::class);
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()){
            $message = $form->get('message')->getData();
            $email = (new Email())
                ->from('verajor.verajor@gmail.com')
                ->to($mailReceiver)
                ->replyTo($mailSender)
                //->priority(Email::PRIORITY_HIGH)
                ->subject('Nouveau contact sur Coolok')
                ->text($message)
                ->html('<p>' . $message .'</p>');

                $mailer->send($email);

                $infoSucces = sprintf('Votre mail a bien été envoyé');
                $this->addFlash('notice', $infoSucces);

        }


        return $this->render('user/view_user.html.twig', [
            'userAge' => $userAge,
            'user' => $view_Profil,
            'isFav' => $isFav,
            'form' => $form->createView(),
        ]);
    }

    // #[Route('/profil/{id}/mail', name: 'sendingMail', requirements: ['id' => '\d+'])]
    // public function sendMail($id, MailerInterface $mailer, User $user, Request $request) : Response
    // {
    //     $user = $this->getUser();
    //     $mailSender = $user->getEmail();
    //     $view_Profil = $this->userRepository->find($id);
    //     $mailReceiver = $view_Profil->getEmail();

    //     $form = $this->createForm(ContactUserType::class);
    //     $form->handleRequest($request);
    //     if ($form->isSubmitted() && $form->isValid()){
    //         $message = $form->get('message');

    //         $email = (new Email())
    //             ->from('verajor.verajor@gmail.com')
    //             ->to($mailReceiver)
    //             ->replyTo($mailSender)
    //             //->priority(Email::PRIORITY_HIGH)
    //             ->subject('Nouveau contact sur Coolok')
    //             ->text($message)
    //             ->html('<p>' . $message .'</p>');

    //             $mailer->send($email);

    //     }
        
    //     return $this->redirectToRoute('main_index');
    // }

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
