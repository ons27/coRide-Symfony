<?php

namespace App\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;



use App\Entity\Trajet;
use App\Service\PdfService;

use App\Entity\TypeTrajet;
use App\Repository\TrajetRepository;
use App\Form\TrajetType;
use App\Repository\TypeTrajetRepository;
use App\Services\EmailService;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Twilio\Rest\Client;
use Swift_Mailer;
use Swift_Message;
use Mpdf\Mpdf;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;


use Dompdf\Dompdf;
use Dompdf\Options;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;

class TrajetController extends AbstractController
{
/*#[Route('/trajet/pdf', name: 'trajet.pdf')]
public function pdf(Trajet $trajet = null, PdfService $pdf, TrajetRepository $trajetRepository): Response
{
    $trajets = $trajetRepository->findAll();

    $html = $this->render('trajet/pdf/index.html.twig', ['trajets' => $trajets]);
    $pdf->showPdfFile($html); 
}
*/
#[Route('/trajet/pdf', name: 'trajet.pdf')]
    public function pdfAllReponses(TrajetRepository $trajetRepository): Response
    {
        // Récupérer toutes les reclamations depuis la base de données
        $trajet = $trajetRepository->findAll();
    
        // Configurer Dompdf selon vos besoins
        $pdfOptions = new Options();
        $pdfOptions->set('defaultFont', 'Arial');
    
        $dompdf = new Dompdf($pdfOptions);
    
        // Charger le contenu HTML des reclamations dans Dompdf
        $dompdf->loadHtml($this->renderView('trajet/pdf/pdf.html.twig', ['trajet' => $trajet]));
    
        // Définir le format de la page
        $dompdf->setPaper('A4', 'portrait');
    
        // Générer le PDF
        $dompdf->render();
    
        // Renvoyer la reclamation avec le contenu PDF en pièce jointe
        $response = new Response($dompdf->output(), 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'attachment; filename="Trajet.pdf"',
        ]);
    
        return $response;
    }

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

   #[Route('/trajet/new', name: 'app_add_trajet')]
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
        $token = '2fcc7309cb16d8cd825859463b5df3a1'; // Replace with your auth token
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
        'subtitle' => 'trajet',
        'form' => $form->createView(),
    ]);
}


#[Route('/trajet/{id}', name: 'app_delete_trajet')]
public function delete(Trajet $trajet/*, \Swift_Mailer $mailer*/): RedirectResponse
{
    $em = $this->getDoctrine()->getManager();
    $em->remove($trajet);
    $em->flush();

   /*// Send email using Swift Mailer
    $message = (new \Swift_Message('Trajet Deleted'))
        ->setFrom('saif.yahyaoui@esprit.tn')
        ->setTo('sirine.benyounes@esprit.tn')
        ->setBody(
            $this->renderView(
                'emails/trajet_deleted.html.twig',
            ),
            'text/html'
        );

    $mailer->send($message);*/

    return $this->redirectToRoute('app_trajet');
}




    


    #[Route('/trajet/{id}/edit', name: 'app_edit_trajet')]
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
