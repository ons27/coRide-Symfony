<?php
namespace App\Controller;

use App\Entity\Trajet;
use App\Form\TrajetType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

class AddTrajetController extends AbstractController
{
    #[Route('/add/trajet', name: 'app_add_trajet')]
    public function index(Request $request): Response
    {
        $trajet = new Trajet();
        $form = $this->createForm(TrajetType::class, $trajet);
        
        $form->handleRequest($request);
        
        if ($form->isSubmitted()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($trajet);
            $em->flush();
            
            return $this->redirectToRoute('app_trajet');
        }
        
        return $this->render('add_trajet/index.html.twig', [
            'controller_name' => 'AddTrajetController',
            'title' => 'Ajouter',
            'subtitle' => 'poste',
            'form'=> $form->createView(),
        ]);
    }
}

