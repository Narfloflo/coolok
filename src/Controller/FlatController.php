<?php

namespace App\Controller;

use App\Form\SearchBarType;
use App\Repository\FlatRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/colocations', name:'flat_')]
class FlatController extends AbstractController
{
    private $flatRepository;
    private $userRepository;
    private $em;

    public function __construct(
        FlatRepository $flatRepository,
        UserRepository $userRepository,
        EntityManagerInterface $em,
    ){
        $this->flatRepository = $flatRepository;
        $this->userRepository = $userRepository;
        $this->em = $em;
    }

    #[Route('', name: 'allFlat')]
    public function index(): Response
    {
        $allFlat = $this->flatRepository->findBy(
            ['available' => 1],
            ['id' => 'DESC'],
            
        );

        return $this->render('flat/index.html.twig', [
            'allFlat' => $allFlat,
        ]);
    }

    #[Route('/mixte', name: 'mixedFlat')]
    public function showMix(): Response
    {
        $mixedFlat = $this->flatRepository->findBy(
            ['gender' => 'all',
            'available' => 1
            ],
            ['id' => 'DESC'],
        );

        return $this->render('flat/mixed.html.twig', [
            'mixedFlat' => $mixedFlat,
        ]);
    }
    
    #[Route('/meublees', name: 'furnishedFlat')]
    public function showFurnished(): Response
    {
        $furnishedFlat = $this->flatRepository->findBy(
            ['furnished' => 'yes',
            'available' => 1
            ],
            ['id' => 'DESC'],
        );

        return $this->render('flat/furnished.html.twig', [
            'furnishedFlat' => $furnishedFlat,
        ]);
    }



    #[Route('/{id}', name: 'show', requirements: ['id' => '\d+'])]
    public function show($id): Response
    {
        $flat = $this->flatRepository->find($id);
        if($this->getUser()){
            $user = $this->getUser();
        $favoriteFlat = $user->getFavoriteFlat();
        if($favoriteFlat->contains($flat)){
            $isFav = true;
        }else{
            $isFav = false;
        }
        }else{
            $isFav = false;
        }
        

        $showFlat = $this->flatRepository->find($id);
        return $this->render('flat/show.html.twig', [
            'flat' => $showFlat,
            'isFav' => $isFav
        ]);
    }

    #[Route('/{id}/favorite', name: 'favorite', requirements: ['id' => '\d+'])]
    public function favoriteflat($id) : Response 
    {
        $flat = $this->flatRepository->find($id);
        if(!$this->getUser()){
            return $this->redirectToRoute('user_login');
        }
        $user = $this->getUser();
        $favoriteFlat = $user->getFavoriteFlat();

        if($favoriteFlat->contains($flat)){
            $user->removeFavoriteFlat($flat);
            $this->addFlash('notice', 'Ce logement a été supprimé de vos favoris');
        }else{
            $user->addFavoriteFlat($flat);
            $this->addFlash('notice', 'Ce logement a été ajouté à vos favoris');
        }
        $this->em->persist($user);
        $this->em->flush();

        return $this->redirectToRoute('flat_show', ['id' => $id]);
    }


    #[Route('/{city}', name: 'cityFlat', requirements: ['city' => '.*'])]
    public function showFlatByCity($city): Response
    {
        $showFlatByCity = $this->flatRepository->findBy(
            ['city' => $city,
            'available' => 1
            ],
            ['id' => 'DESC'],
        );

        return $this->render('flat/cityflats.html.twig', [
            'cityFlats' => $showFlatByCity,
        ]);
    }

}
