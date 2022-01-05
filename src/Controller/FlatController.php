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

    #[Route('/show', name: 'show')]
    public function show(): Response
    {
        return $this->render('flat/show.html.twig', [
            'controller_name' => 'FlatController',
        ]);
    }
}
