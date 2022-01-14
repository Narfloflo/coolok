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

        // on supprime l'utilisateur en cours 
        for($i = 0; $i < count($usersAvailable); $i++){
            if($usersAvailable[$i]->getId() === $currentUser->getId()){
                array_splice($usersAvailable, $i, 1);
            };
        }
        
        $usersAvailableAge = $this->userService->calculAges($usersAvailable);

        return $this->render('matching/matching.html.twig', [
            'users' => $usersAvailable,
            'usersAvailableAge' => $usersAvailableAge,
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
        
        
        // // Add match_user ok 
        // $currentUser->addMatching($userB);
        // $this->em->persist($currentUser);
        // $this->em->flush();


        // Add first matching
        $newMatching = new Matching();
        $newMatching->setUserA($currentUser);
        $newMatching->setUserB($userB);
        $this->em->persist($newMatching);
        $this->em->flush();

        

        return $this->redirectToRoute('matching_list');
    }
}
