<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CommentaireExpController extends AbstractController
{
    #[Route('/commentaire/exp', name: 'app_commentaire_exp')]
    public function index(): Response
    {
        return $this->render('commentaire_exp/index.html.twig', [
            'controller_name' => 'CommentaireExpController',
        ]);
    }
}
