<?php

namespace App\Controller;

use App\Entity\Poste;
use App\Repository\PosteRepository;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PostesController extends AbstractController
{
    #[Route('/postes', name: 'app_postes')]
    public function index(PosteRepository $PosteRepository): Response
    {
       /* $em = $this->getDoctrine()->getManager();
        $poste1 = new Poste();
        $poste1->setUser('user01');
        $poste1->setTrajet('000111');
        $poste1->setVehicule('v10');
        $poste1->setPrix(10.5);
        $poste1->setDepart('d000');
        $poste1->setArrive('a111');
        $em->persist($poste1);
        $em->flush();
       */
        return $this->render('postes/index.html.twig', [
            'controller_name' => 'PostesController',
            'postes' => $PosteRepository->findAll(),
            'title' => 'Historique',
            'subtitle' => 'postes',
        ]);
    }
    
    #[Route('/postes/sort', name: 'app_postes_sort')]
    public function sort(PosteRepository $posteRepository): Response
    {
        $postes = $posteRepository->findBy([], ['typepost' => 'ASC']);
        return $this->render('postes/sorted.html.twig', [
            'postes' => $postes,
            'title' => 'Historique',
            'subtitle' => 'postes triés par Type',
        ]);
    }
    
    
}
