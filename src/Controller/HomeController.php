<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index()
    {
        return $this->render('home/index.html.twig', [
            'title' => 'Join our family',
            'subtitle' => 'CoRide',
]);
       
    }

    #[Route('/name/{name}', name: 'name', defaults: ['name' => 'vide'], methods: ['GET'])]
    public function param($name)
    {
        return new Response(
        "salut $name !"
        );
    }
}
