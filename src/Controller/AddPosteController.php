<?php

namespace App\Controller;

use App\Entity\Poste;
use App\Form\PosteType;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;


class AddPosteController extends AbstractController
{
    #[Route('/postes/new', name: 'app_add_poste')]
    public function index(Request $request): Response
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
        return $this->render('add_poste/index.html.twig', [
            'controller_name' => 'AddPosteController',
            'title' => 'Ajouter',
            'subtitle' => 'poste',
            'form'=> $form->createView(),
            
        ]);
    }
}
