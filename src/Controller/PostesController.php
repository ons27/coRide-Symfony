<?php

namespace App\Controller;

use App\Entity\Poste;
use App\Form\PosteType;

use App\Repository\PosteRepository;

use App\Entity\TypePublication;
use App\Repository\TypePublicationRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\RedirectResponse;

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

    #[Route('/postes/new', name: 'app_add_poste')]
    public function add(Request $request): Response
    {  
        // Initialize cURL.
        $ch = curl_init();

        // Set the URL that you want to GET by using the CURLOPT_URL option.
        curl_setopt($ch, CURLOPT_URL, 'https://date.nager.at/api/v3/PublicHolidays/2023/TN');

        // Set CURLOPT_RETURNTRANSFER so that the content is returned as a variable.
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        // Set CURLOPT_FOLLOWLOCATION to true to follow redirects.
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);

        // Set CURLOPT_SSL_VERIFYPEER to false to disable certificate verification.
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

        // Execute the request.
        $holidays = curl_exec($ch);

        // Close the cURL handle.
        curl_close($ch);

        $holidaysArray = json_decode($holidays, true);
              
        $poste=new Poste();
        $form=$this->createForm(PosteType::class, $poste);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $em = $this->getDoctrine()->getManager();
            $em->persist($poste);
            $em->flush();
            return $this->redirectToRoute('app_postes');
        }
        return $this->render('postes/add_poste.html.twig', [
            'controller_name' => 'PosteController',
            'title' => 'Ajouter',
            'subtitle' => 'poste',
            'form'=> $form->createView(),
            'holidays' => $holidaysArray,

        ]);
    }


    #[Route('/postes/{id}/delete', name: 'app_delete_poste')]
    public function delete(Poste $poste): RedirectResponse
    {
        $em = $this->getDoctrine()->getManager();
        $em->remove($poste);
        $em->flush();

        return $this->redirectToRoute('app_postes'); //specific the name of the route
    }


    #[Route('/postes/{id}/edit', name: 'app_edit_poste')]
    public function edit(Poste $poste, Request $request): Response
    {
        $form=$this->createForm(PosteType::class, $poste);
        $form->handleRequest($request);
        if($form->isSubmitted()){
            $em = $this->getDoctrine()->getManager();
            $em->flush();
            return $this->redirectToRoute('app_postes'); //specific the name of the route
        }
      
        return $this->render('postes/edit_poste.html.twig', [
            'controller_name' => 'PosteController',
            'title' => 'Editer',
            'subtitle' => 'poste',
            'form' => $form->createView(),
        ]);
    }
}


    
    

