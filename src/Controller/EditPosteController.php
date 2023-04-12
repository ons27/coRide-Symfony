<?php

namespace App\Controller;
use App\Entity\Poste;
use App\Form\PosteType;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

class EditPosteController extends AbstractController
{
    #[Route('/postes/{id}/edit', name: 'app_edit_poste')]
    public function index(Poste $poste, Request $request): Response
    {
        $form=$this->createForm(PosteType::class, $poste);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $em = $this->getDoctrine()->getManager();
            $em->flush();
            return $this->redirectToRoute('app_postes'); //specific the name of the route
        }
      
        return $this->render('edit_poste/index.html.twig', [
            'controller_name' => 'EditPosteController',
            'title' => 'Editer',
            'subtitle' => 'poste',
            'form' => $form->createView(),
        ]);
    }
}
