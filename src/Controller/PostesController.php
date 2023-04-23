<?php

namespace App\Controller;

use App\Entity\Poste;
use App\Repository\PosteRepository;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use Symfony\Component\HttpFoundation\Request;

class PostesController extends AbstractController
{
    #[Route('/postes', name: 'app_postes')]
    public function index(PosteRepository $PosteRepository,Request $request): Response
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
      $searchTerm = $request->query->get('q');
      if ($searchTerm) {
          $postes = $PosteRepository->findBySearchTerm($searchTerm);
      } else {
          $postes = $PosteRepository->findBy([], ['trajet' => 'ASC']);
      }
  
      return $this->render('postes/index.html.twig', [
          'controller_name' => 'PostesController',
          'postes' => $postes,
          'title' => 'Historique',
          'subtitle' => 'postes',
          'searchTerm' => $searchTerm,
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
