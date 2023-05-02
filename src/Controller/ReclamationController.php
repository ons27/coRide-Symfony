<?php

namespace App\Controller;

use App\Entity\Reclamation;
use App\Entity\TypeReclamation;
use App\Form\TypeReclamationType;

use App\Form\ReclamationType;
use App\Repository\ReclamationRepository;
use App\Repository\TypeReclamationRepository;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Routing\Annotation\Route;
use Dompdf\Dompdf;
use Dompdf\Options;

class ReclamationController extends AbstractController
{
    #[Route('/reclamation', name: 'app_reclamation_index', methods: ['GET'])]
    public function index(ReclamationRepository $ReclamationRepository , TypeReclamationRepository $TypeReclamationRepository, Request $request): Response
    {
        $searchTerm = $request->query->get('q');
        $typeRec = $request->query->get('type_r');
        if ($searchTerm) {
            $reclamations = $ReclamationRepository->findBySearchTerm($searchTerm);
        } else if ($typeRec) {
            $typeReclamation = $TypeReclamationRepository->findOneBy(['type_r' => $typeRec]);
            $reclamations = $ReclamationRepository->findBy(['typeReclamation' => $typeReclamation], ['text_rec' => 'ASC']);
        } else {
            $reclamations = $ReclamationRepository->findBy([], ['text_rec' => 'ASC']);
        }
        $typeReclamations = $TypeReclamationRepository->findAll();
        return $this->render('reclamation/index.html.twig', [
            'controller_name' => 'ReclamationController',
            'reclamation' => $reclamations,
            'title' => 'Historique',
            'subtitle' => 'reclamation',
            'searchTerm' => $searchTerm,
            'typeReclamations' => $typeReclamations,
            'selectedType' => $typeRec
        ]);
    }

    #[Route('/reclamation/new', name: 'app_reclamation_new', methods: ['GET', 'POST'])]
    public function add(Request $request, MailerInterface $mailer): Response
    {
        $reclamation = new Reclamation();
        $form = $this->createForm(ReclamationType::class, $reclamation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
        $em->persist($reclamation);
        $em->flush();
 // Envoi de l'e-mail
 $email = (new Email())
 ->from('bouhjarons27@gmail.com')
 ->to('bouhjarons27@gmail.com')
 ->subject('Nouvelle réclamation')
 ->html('<p>Une nouvelle réclamation a été soumise:</p>' .
 '<ul>' .
 '<li>Type de reclamation: ' . $reclamation->getTypeReclamation() . '</li>' .
 '<li>Sujet: ' . $reclamation->getSujet() . '</li>' .
 '<li>Reclamation: ' . $reclamation->getTextRec() . '</li>' .
 '</ul>');


$mailer->send($email);
            return $this->redirectToRoute('app_reclamation_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('reclamation/new.html.twig', [
            'title' => 'Ajouter',
            'subtitle' => 'reclamations',
            'controller_name' => 'ReclamationController',

            'form' => $form->createView(),
        ]);
    }

    #[Route('/reclamation/{id}', name: 'app_reclamation_show', methods: ['GET'])]
    public function show(Reclamation $reclamation): Response
    {
        return $this->render('reclamation/show.html.twig', [
            'reclamation' => $reclamation,
        ]);
    }

    #[Route('/reclamation/{id}/edit', name: 'app_reclamation_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Reclamation $reclamation, ReclamationRepository $reclamationRepository): Response
    {
        $form = $this->createForm(ReclamationType::class, $reclamation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $reclamationRepository->save($reclamation, true);

            return $this->redirectToRoute('app_reclamation_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('reclamation/edit.html.twig', [
            'reclamation' => $reclamation,
            'form' => $form,
        ]);
    }

    #[Route('/reclamation/{id}', name: 'app_reclamation_delete')]
    public function delete(Reclamation $reclamation): RedirectResponse
    {
            $em = $this->getDoctrine()->getManager();
        $em->remove($reclamation);
        $em->flush();
        

        return $this->redirectToRoute('app_reclamation_index', [], Response::HTTP_SEE_OTHER);
    }




  

    #[Route('/reclamation/pdf/{id}', name: 'app_rec_pdf')]
    public function PDFreponse($id, ReclamationRepository $repo)
    {
        $reclamation = $repo->find($id);
        $reclamations = [$reclamation];
    
        // Configure Dompdf according to your needs
        $pdfOptions = new Options();
        $pdfOptions->set('defaultFont', 'Arial');
    
        // Instantiate Dompdf with our options
        $dompdf = new Dompdf($pdfOptions);
    
        // Retrieve the HTML generated in our twig file
        $dompdf->loadHtml($this->renderView('reclamation/pdf.html.twig', [
            'reclamation' => $reclamations
        ]));
    
        // Load HTML to Dompdf
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();
    
        // Set the response content
        $response = new Response();
        $response->headers->set('Content-Type', 'application/pdf');
        $response->setContent($dompdf->output());
    
        // Return the response
        return $response;
    }
    


    
    #[Route('/pdffff', name: 'pdf_all_recs')]
    public function pdfAllReponses(ReclamationRepository $repo): Response
    {
        // Récupérer toutes les reclamations depuis la base de données
        $reclamations = $repo->findAll();
    
        // Configurer Dompdf selon vos besoins
        $pdfOptions = new Options();
        $pdfOptions->set('defaultFont', 'Arial');
    
        $dompdf = new Dompdf($pdfOptions);
    
        // Charger le contenu HTML des reclamations dans Dompdf
        $dompdf->loadHtml($this->renderView('reclamation/pdf.html.twig', ['reclamation' => $reclamations]));
    
        // Définir le format de la page
        $dompdf->setPaper('A4', 'portrait');
    
        // Générer le PDF
        $dompdf->render();
    
        // Renvoyer la reclamation avec le contenu PDF en pièce jointe
        $response = new Response($dompdf->output(), 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'attachment; filename="Toutes_les_reclamations.pdf"',
        ]);
    
        return $response;
    }
    

}
