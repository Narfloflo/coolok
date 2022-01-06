<?php

namespace App\Controller;

use App\Repository\FlatRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('', name:'flat_')]
class FlatController extends AbstractController
{
    private $flatRepository;

    public function __construct(
        FlatRepository $flatRepository,
    ){
        $this->flatRepository = $flatRepository;
    }

    #[Route('/colocation', name: 'allFlat')]
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

    #[Route('/mixColocation', name: 'mixedFlat')]
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
    
    #[Route('/furnishedColocation', name: 'furnishedFlat')]
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

    #[Route('/show{id}', name: 'show', requirements: ['id' => '\d+'])]
    public function show($id): Response
    {
        $showFlat = $this->flatRepository->find($id);
        return $this->render('flat/show.html.twig', [
            'flat' => $showFlat,
        ]);
    }
}
