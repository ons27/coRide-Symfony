<?php

namespace App\Controller;

use App\Entity\Poste;
use App\Form\PosteType;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

use GuzzleHttp\Client;

class AddPosteController extends AbstractController
{
    #[Route('/postes/new', name: 'app_add_poste')]
    public function index(Request $request): Response
    {  
        // Initialize cURL.
        $ch = curl_init();

        // Set the URL that you want to GET by using the CURLOPT_URL option.
        curl_setopt($ch, CURLOPT_URL, 'https://date.nager.at/api/v3/PublicHolidays/2023/TN');

        // Set CURLOPT_RETURNTRANSFER so that the content is returned as a variable.
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        // Set CURLOPT_FOLLOWLOCATION to true to follow redirects.
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);

        // Set CURLOPT_SSL_VERIFYPEER to false to disable certificate verification.
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

        // Execute the request.
        $holidays = curl_exec($ch);

        // Close the cURL handle.
        curl_close($ch);

        $holidaysArray = json_decode($holidays, true);
              
        $poste=new Poste();
        $form=$this->createForm(PosteType::class, $poste);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $em = $this->getDoctrine()->getManager();
            $em->persist($poste);
            $em->flush();
            return $this->redirectToRoute('app_postes');
        }
        return $this->render('add_poste/index.html.twig', [
            'controller_name' => 'AddPosteController',
            'title' => 'Ajouter',
            'subtitle' => 'poste',
            'form'=> $form->createView(),
            'holidays' => $holidaysArray,

        ]);
    }
}
