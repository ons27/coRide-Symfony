<?php

namespace App\Controller;

use App\Entity\Poste;
use App\Repository\PosteRepository;
use App\Entity\TypePublication;
use App\Repository\TypePublicationRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use Symfony\Component\HttpFoundation\Request;

class PostesController extends AbstractController
{
    #[Route('/postes', name: 'app_postes')]
    public function index(PosteRepository $PosteRepository, Request $request, TypePublicationRepository $typePublicationRepository): Response
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
      $type = $request->query->get('type');

      if ($searchTerm) {
          $postes = $PosteRepository->findBySearchTerm($searchTerm);
      } 
      else if ($type) {
        $typePublication = $typePublicationRepository->findOneBy(['type' => $type]);
        $postes = $PosteRepository->findBy(['typepost' => $typePublication], ['trajet' => 'ASC']);
      }
      else {
          $postes = $PosteRepository->findBy([], ['trajet' => 'ASC']);
      }
      $types = $typePublicationRepository->findAll();
  
      return $this->render('postes/index.html.twig', [
          'controller_name' => 'PostesController',
          'postes' => $postes,
          'title' => 'Historique',
          'subtitle' => 'postes',
          'searchTerm' => $searchTerm,
          'types' => $types,
          'selectedType' => $type,
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
