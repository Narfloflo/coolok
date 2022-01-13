<?php

namespace App\Controller;

use App\Form\SearchBarType;
use App\Form\SearchFlatType;
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
    
    // #[Route('/search', name: 'search')]
    // public function searchFlat(Request $request): Response
    // {
    //     $searchFlat = $this->createForm(SearchBarType::class);
    //     $searchFlat->handleRequest($request);
    //     $searchCriteria = $searchFlat->getData();
    //     // $q = $request->query->get('query');
    //     // $option = $request->query->get('searchAdv');


    //     $flats = $this->flatRepository->search($searchCriteria);

    //     return $this->render('search/searchResult.html.twig', [
    //         'flats' => $flats,
    //         'searchForm' => $searchFlat->createView(),
    //     ]);
    // }

    #[Route('/recherche', name: 'search')]
    public function searchFull(Request $request): Response
    {
        $searchFlat = $request->query->all()['search_flat']['query'];
        if($searchFlat === ""){
            $Query = '';
        }else{
            $Query = 'Appartement';
        }

        $globalSearchForm = $this->createForm(SearchFlatType::class, [
            'Query' => $Query,
        ]);
        $globalSearchForm->handleRequest($request);
        $searchCriteria = $globalSearchForm->getData();

        $flats = $this->flatRepository->search($searchCriteria);

        return $this->render('search/search_result.html.twig', [
            'flats' => $flats,
            'searchForm' => $globalSearchForm->createView(),
        ]);

    }
}
