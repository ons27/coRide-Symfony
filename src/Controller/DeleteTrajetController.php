<?php

namespace App\Controller;

use App\Entity\Trajet;
use App\Form\TrajetType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;


class DeleteTrajetController extends AbstractController
{
    #[Route('/delete/trajet/{id}', name: 'app_delete_trajet')]
    public function index(Trajet $trajet): RedirectResponse
    {
        $em = $this->getDoctrine()->getManager();
        $em->remove($trajet);
        $em->flush();

        return $this->redirectToRoute('app_trajet');
    }
}





