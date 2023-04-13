<?php

namespace App\Controller;
use App\Entity\Trajet;
use App\Form\TrajetType;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;


class EditTrajetController extends AbstractController
{
    #[Route('/edit/{id}/trajet', name: 'app_edit_trajet')]
    public function index(Trajet $trajet, Request $request): Response
    {
        $form=$this->createForm(TrajetType::class, $trajet);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $em = $this->getDoctrine()->getManager();
            $em->flush();
            return $this->redirectToRoute('app_trajet'); //specific the name of the route
        }
        return $this->render('edit_trajet/index.html.twig', [
            'controller_name' => 'EditTrajetController',
            'title' => 'Editer',
            'subtitle' => 'trajet',
            'form' => $form->createView(),
        ]);
    }
}




