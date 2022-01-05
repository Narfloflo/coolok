<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('', name:'flat_')]
class FlatController extends AbstractController
{
    #[Route('/flat', name: 'flat')]
    public function index(): Response
    {
        return $this->render('flat/index.html.twig', [
            'controller_name' => 'FlatController',
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
