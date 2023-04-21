<?php

namespace App\Controller;

use App\Entity\Trajet;
use App\Repository\TrajetRepository;
use App\Form\TrajetType;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;

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
    #[Route('/add/trajet', name: 'app_add_trajet')]
    public function add (Request $request): Response
    {
        $trajet = new Trajet();
        $form = $this->createForm(TrajetType::class, $trajet);
        
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($trajet);
            $em->flush();
            
            return $this->redirectToRoute('app_trajet');
        }
        
        return $this->render('trajet/add_trajet.html.twig', [
            'controller_name' => 'TrajetController',
            'title' => 'Ajouter',
            'subtitle' => 'poste',
            'form'=> $form->createView(),
        ]);
    }
    #[Route('/trajet/{id}', name: 'app_delete_trajet')]
    public function delete(Trajet $trajet): RedirectResponse
    {
        $em = $this->getDoctrine()->getManager();
        $em->remove($trajet);
        $em->flush();

        return $this->redirectToRoute('app_trajet');
    }
    #[Route('/{id}/trajet', name: 'app_edit_trajet')]
    public function edit (Trajet $trajet, Request $request): Response
    {
        $form=$this->createForm(TrajetType::class, $trajet);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $em = $this->getDoctrine()->getManager();
            $em->flush();
            return $this->redirectToRoute('app_trajet'); //specific the name of the route
        }
        return $this->render('trajet/edit_trajet.html.twig', [
            'controller_name' => 'TrajetController',
            'title' => 'Editer',
            'subtitle' => 'trajet',
            'form' => $form->createView(),
        ]);
    }
}



