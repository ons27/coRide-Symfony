<?php

namespace App\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

use App\Entity\Trajet;
use App\Repository\TrajetRepository;
use App\Form\TrajetType;
use App\Repository\TypeTrajetRepository;
use Twilio\Rest\Client;


use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;

class TrajetController extends AbstractController
{

    #[Route('/trajet', name: 'app_trajet')]
    public function index(TrajetRepository $TrajetRepository, TypeTrajetRepository $TypeTrajetRepository, Request $request): Response
    {
        $searchTerm = $request->query->get('q');
        $type = $request->query->get('typet');
        if ($searchTerm) {
            $trajets = $TrajetRepository->findBySearchTerm($searchTerm);
        } else if ($type) {
            $typeTrajet = $TypeTrajetRepository->findOneBy(['typet' => $type]);
            $trajets = $TrajetRepository->findBy(['typeTrajet' => $typeTrajet], ['depart' => 'ASC']);
        } else {
            $trajets = $TrajetRepository->findBy([], ['depart' => 'ASC']);
        }
        $types = $TypeTrajetRepository->findAll();
        return $this->render('trajet/index.html.twig', [
            'controller_name' => 'TrajetController',
            'trajet' => $trajets,
            'title' => 'Historique',
            'subtitle' => 'trajet',
            'searchTerm' => $searchTerm,
            'types' => $types,
            'selectedType' => $type
        ]);
    }


    #[Route('/add/trajet', name: 'app_add_trajet')]
public function add(Request $request): Response
{
    $trajet = new Trajet();
    $form = $this->createForm(TrajetType::class, $trajet);

    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
        $em = $this->getDoctrine()->getManager();
        $em->persist($trajet);
        $em->flush();

        // Send SMS using Twilio
        $sid = 'ACa62721605d27320e2270fec6eb12370c'; // Replace with your account SID
        $token = '3867b3227dbd9316a7b29b3ca738a698'; // Replace with your auth token
        $twilio = new Client($sid, $token);

        $recipient_number = '+21620947998'; // Replace with the recipient phone number
        $twilio_number = '+16813956324'; // Replace with your Twilio phone number
        $message_body = 'Votre trajet est ajouter: ' . $trajet->getDepart(); // Replace with your desired SMS message body

        $message = $twilio->messages
            ->create(
                $recipient_number,
                array(
                    'from' => $twilio_number,
                    'body' => $message_body
                )
            );

        return $this->redirectToRoute('app_trajet');
    }

    return $this->render('trajet/add_trajet.html.twig', [
        'controller_name' => 'TrajetController',
        'title' => 'Ajouter',
        'subtitle' => 'poste',
        'form' => $form->createView(),
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
    public function edit(Trajet $trajet, Request $request): Response
    {
        $form = $this->createForm(TrajetType::class, $trajet);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
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
