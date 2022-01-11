<?php

namespace App\Controller;

use App\Form\SearchBarType;
use App\Repository\FlatRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class SearchController extends AbstractController
{
    private $flatRepository;

    public function __construct(
        FlatRepository $flatRepository,
    ){
        $this->flatRepository = $flatRepository;
    }
    
    #[Route('/search', name: 'search')]
    public function searchFlat(Request $request): Response
    {
        $searchFlat = $this->createForm(SearchBarType::class);
        $searchFlat->handleRequest($request);
        //$searchCriteria = $searchFlat->getData();
        $q = $request->query->get('query');
        $option = $request->query->get('searchAdv');


        $flats = $this->flatRepository->search($q, $option);

        return $this->render('flat/searchFlat.html.twig', [
            'flats' => $flats,
            'searchFlat' => $searchFlat->createView(),
        ]);
    }
}
