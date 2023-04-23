<?php

namespace App\Controller;
use App\Entity\Poste;
use App\Form\PosteType;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;


class DeletePosteController extends AbstractController
{
    #[Route('/postes/{id}/delete', name: 'app_delete_poste')]
    public function index(Poste $poste): RedirectResponse
    {
        $em = $this->getDoctrine()->getManager();
        $em->remove($poste);
        $em->flush();

        return $this->redirectToRoute('app_postes'); //specific the name of the route
    }
}
