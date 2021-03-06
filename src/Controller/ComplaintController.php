<?php

namespace App\Controller;

use App\Entity\Complaint;
use App\Form\ComplaintType;
use App\Repository\ComplaintRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/complaint")
 */
class ComplaintController extends AbstractController
{
    /**
     * @Route("/", name="complaint_index", methods={"GET"})
     * @param ComplaintRepository $complaintRepository
     * @return Response
     */
    public function index(ComplaintRepository $complaintRepository): Response
    {
        return $this->render('complaint/index.html.twig', [
            'complaints' => $complaintRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="complaint_new", methods={"GET","POST"})
     * @param Request $request
     * @return Response
     */
    public function new(Request $request): Response
    {
        $complaint = new Complaint();
        $form = $this->createForm(ComplaintType::class, $complaint);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($complaint);
            $entityManager->flush();

            return $this->redirectToRoute('complaint_index');
        }

        return $this->render('complaint/new.html.twig', [
            'complaint' => $complaint,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="complaint_show", methods={"GET"})
     * @param Complaint $complaint
     * @return Response
     */
    public function show(Complaint $complaint): Response
    {
        return $this->render('complaint/show.html.twig', [
            'complaint' => $complaint,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="complaint_edit", methods={"GET","POST"})
     * @param Request $request
     * @param Complaint $complaint
     * @return Response
     */
    public function edit(Request $request, Complaint $complaint): Response
    {
        $form = $this->createForm(ComplaintType::class, $complaint);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('complaint_index');
        }

        return $this->render('complaint/edit.html.twig', [
            'complaint' => $complaint,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="complaint_delete", methods={"DELETE"})
     * @param Request $request
     * @param Complaint $complaint
     * @return Response
     */
    public function delete(Request $request, Complaint $complaint): Response
    {
        if ($this->isCsrfTokenValid('delete'.$complaint->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($complaint);
            $entityManager->flush();
        }

        return $this->redirectToRoute('complaint_index');
    }
}
