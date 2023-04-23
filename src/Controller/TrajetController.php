<?php

namespace App\Controller;

use App\Entity\Trajet;
use App\Repository\TrajetRepository;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TrajetController extends AbstractController
{
    #[Route('/trajet', name: 'app_trajet')]
    public function index(TrajetRepository $TrajetRepository): Response
    {
        return $this->render('trajet/index.html.twig', [
            'controller_name' => 'TrajetController',
            'trajet' => $TrajetRepository->findAll(),
            'title' => 'Historique',
            'subtitle' => 'trajet',
        ]);
    }
}



