<?php

namespace App\Controller;

use App\Entity\Moyentransport;
use App\Form\MoyentransportType;
use App\Repository\MoyentransportRepository;
use Exception;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Form\MoyentrasportType;
use Symfony\Component\Form\FormTypeInterface;


class MoyentransportController extends AbstractController
{
    #[Route('/moyentransport', name: 'app_moyentransport')]
    public function index(Request $request, MoyentransportRepository $moyentransportRepository): Response
    {   $orderBy = $request->query->get('orderBy', 'id_moy'); // default to sorting by id_moy
        $direction = $request->query->get('direction', 'desc'); // default to descending order
    
        if ($direction !== 'asc' && $direction !== 'desc') {
            $direction = 'asc';
        }
        $moyentransports = $moyentransportRepository->findBy([], [$orderBy => $direction]);
    
    
        return $this->render('moyentransport/index.html.twig', [
            'moyentransports' => $moyentransports,
            'orderBy' => $orderBy,
            'direction' => $direction,
        ]);
    }
    #[Route('/moyentransport/new', name: 'app_add_moyentransport')]
    public function add(Request $request): Response
    {
        $moyentransport = new Moyentransport();
        $form = $this->createForm(MoyentransportType::class, $moyentransport);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($moyentransport);
            $em->flush();
            return $this->redirectToRoute('app_moyentransport', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('moyentransport/add.html.twig', [
            'moyentransport' => $moyentransport,
            'form' => $form,
        ]);
    }
    #[Route('/moyentransport/{id}/delete', name: 'app_delete_moyentransport')]
    public function delete(Moyentransport $moyentransport): RedirectResponse
    {
        $em = $this->getDoctrine()->getManager();
        $em->remove($moyentransport);
        $em->flush();

        return $this->redirectToRoute('app_moyentransport'); //specific the name of the route
    }

     #[Route('/moyentransport/{id}', name: 'app_moyentransport_show', methods: ['GET'])]
     public function show(Moyentransport $moyentransport): Response
     {
         return $this->render('moyentransport/index.html.twig', [
             'moyentransport' => $moyentransport,
         ]);
     }
   
    #[Route('/moyentransport/{id}/edit', name: 'app_moyentransport_edit')]
   public function edit(Request $request, Moyentransport $moyentransport): Response
    {
        $form = $this->createForm(MoyentransportType::class, $moyentransport);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->flush();
            return $this->redirectToRoute('app_moyentransport', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('moyentransport/edit.html.twig', [
            'moyentransport' => $moyentransport,
            'form' => $form,
        ]);
    }
}
