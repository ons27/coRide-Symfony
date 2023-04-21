<?php

namespace App\Controller;

use App\Entity\Poste;
use App\Form\PosteType;
use App\Repository\PosteRepository;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;

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
    #[Route('/postes/new', name: 'app_add_poste')]
    public function add (Request $request): Response
    {
        $poste=new Poste();
        $form=$this->createForm(PosteType::class, $poste);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $em = $this->getDoctrine()->getManager();
            $em->persist($poste);
            $em->flush();
            return $this->redirectToRoute('app_postes'); //specific the name of the route
        }
        return $this->render('postes/add_poste.html.twig', [
            'controller_name' => 'PosteController',
            'title' => 'Ajouter',
            'subtitle' => 'poste',
            'form'=> $form->createView(),
            
        ]);
    }
    #[Route('/postes/{id}/delete', name: 'app_delete_poste')]
    public function delete (Poste $poste): RedirectResponse
    {
        $em = $this->getDoctrine()->getManager();
        $em->remove($poste);
        $em->flush();

        return $this->redirectToRoute('app_postes'); //specific the name of the route
    }
    #[Route('/postes/{id}/edit', name: 'app_edit_poste')]
    public function edit (Poste $poste, Request $request): Response
    {
        $form=$this->createForm(PosteType::class, $poste);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
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
