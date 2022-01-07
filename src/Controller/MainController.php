<?php

namespace App\Controller;

use App\Repository\FlatRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('', name: 'main_')]
class MainController extends AbstractController
{
    private $flatRepository;
    private $userRepository;

    public function __construct(
        FlatRepository $flatRepository,
        UserRepository $userRepository,
    ){
        $this->flatRepository = $flatRepository;
        $this->userRepository = $userRepository;
    }

    #[Route('/', name: 'index')]
    public function index(): Response
    {
        $lastFlat = $this->flatRepository->findBy(
            ['available' => 1],
            ['id' => 'DESC'],
            4,
        );

        $newUser = $this->userRepository->findBy(
            ['available' => 1],
            ['id' => 'DESC'],
            6,
        );

        $mixedFlat = $this->flatRepository->findBy(
            ['gender' => 'all',
            'available' => 1
            ],
            ['id' => 'DESC'],
            4,
        );

        $furnishedFlat = $this->flatRepository->findBy(
            ['furnished' => 'yes',
            'available' => 1
            ],
            ['id' => 'DESC'],
            4,
        );

        $biggestCity = $this->flatRepository->flatBiggestCity(6);

        return $this->render('main/index.html.twig', [
            'lastFlat' => $lastFlat,
            'newUser' => $newUser,
            'mixedFlat' => $mixedFlat,
            'furnishedFlat' => $furnishedFlat,
            'flatBiggestCity' => $biggestCity,
        ]);
    }
}
