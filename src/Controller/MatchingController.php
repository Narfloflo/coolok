<?php

namespace App\Controller;

use App\Entity\Matching;
use App\Repository\MatchingRepository;
use App\Service\UserService;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Validator\Constraints\NotNull;

#[Route('/matching', name:'matching_')]
class MatchingController extends AbstractController
{
    private $em;
    private $userRepository;
    private $userService;
    private $matchingRepository;

    public function __construct(
        EntityManagerInterface $em,
        UserRepository $userRepository,
        UserService $userService,
        MatchingRepository $matchingRepository,
    ){
        $this->em = $em;;
        $this->userRepository = $userRepository;
        $this->userService = $userService;
        $this->matchingRepository = $matchingRepository;
    }


    #[Route('', name: 'list')]
    public function index(): Response
    {
        if (!$this->getUser()) {
            throw $this->createAccessDeniedException();
        }
        $currentUser = $this->getUser();

        $usersAvailable = $this->userRepository->findBy(
            ['available' => 1],
        );

        // on supprime l'utilisateur en cours des profils à présenter
        foreach ($usersAvailable as $key => $user)
        {
            if ($user->getId() === $currentUser->getId())
            {
                unset($usersAvailable[$key]);
            }
        }

        // on recupere les utilisateurs déjà matché
        $alreadyMatch = $this->matchingRepository->alreadyMatch($currentUser);

        // on supprime les utilisateurs déjà matché des profils à présenter
        if(count($alreadyMatch) != 0){
            foreach($usersAvailable as $keyA => $user)
            {
                foreach($alreadyMatch as $keyB => $match)
                {
                    if($user->getId() === $match->getId()){
                        unset($usersAvailable[$keyA]);
                    }
                }
            }
        }

        $random_keys = array_rand($usersAvailable,1);
        $userToDisplay = $usersAvailable[$random_keys];

        $userToDisplayAge = $this->userService->calculAge($userToDisplay);

        return $this->render('matching/matching.html.twig', [
            'user' => $userToDisplay,
            'userAge' => $userToDisplayAge,
        ]);
    }

    #[Route('/accept/{id} ', name: 'accept', requirements: ['id' => '\d+'])]
    public function accept($id): Response
    {
        if (!$this->getUser()) {
            throw $this->createAccessDeniedException();
        }
        $currentUser = $this->getUser();
        $userB = $this->userRepository->find($id);
        
        $alreadyMatch = $this->matchingRepository->findBy(
            ['userB' => $currentUser],
        );

        if(count($alreadyMatch) != 0){
            for($i = 0; $i < count($alreadyMatch) ; $i++){
                // Verification si A à déjà match B
                if($alreadyMatch[$i]->getUserB() == $currentUser){
                    $idMatching = $alreadyMatch[$i]->getId();
                    $matching = $this->matchingRepository->find($idMatching);
                    $matching->setMatchingBAt(new \DateTime());
                    $matching->setFullMatchingAt(new \DateTime());
                    break;
                }
        }}else{
            //Sinon on crée le premier match
            $matching = new Matching();
            $matching->setUserA($currentUser);
            $matching->setUserB($userB);
        }
        $this->em->persist($matching);
        $this->em->flush();

        return $this->redirectToRoute('matching_list');
    }

    #[Route('/deny/{id} ', name: 'deny', requirements: ['id' => '\d+'])]
    public function deny($id): Response
    {
        if (!$this->getUser()) {
            throw $this->createAccessDeniedException();
        }
        $currentUser = $this->getUser();
        $userB = $this->userRepository->find($id);
        
        $alreadyMatch = $this->matchingRepository->findBy(
            ['userB' => $currentUser],
        );

        if(count($alreadyMatch) != 0){
            for($i = 0; $i < count($alreadyMatch) ; $i++){
                // Verification si A à déjà match B
                if($alreadyMatch[$i]->getUserB() == $currentUser){
                    $idMatching = $alreadyMatch[$i]->getId();
                    $matching = $this->matchingRepository->find($idMatching);
                    $matching->setMatchingBAt(new \DateTime());
                    break;
                }
        }}else{
            //Sinon on crée le premier match
            $matching = new Matching();
            $matching->setUserA($currentUser);
            $matching->setUserB($userB);
        }

        $this->em->persist($matching);
        $this->em->flush();

        return $this->redirectToRoute('matching_list');
    }
}
