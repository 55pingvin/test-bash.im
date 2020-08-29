<?php

namespace App\Controller;

use App\Entity\Complaint;
use App\Entity\Post;
use App\Form\ComplaintType;
use App\Services\PostService;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class IndexController extends AbstractController
{
    /**
     * @Route("/", name="index")
     * @param EntityManagerInterface $em
     * @param PaginatorInterface $paginator
     * @param Request $request
     * @return Response
     */
    public function index(EntityManagerInterface $em, PaginatorInterface $paginator, Request $request): Response
    {
        $postService = new PostService();
        $pagination = $postService->getPostList($em, $paginator, $request);

        $complaint = new Complaint();
        $complaintForm = $this->createForm(ComplaintType::class, $complaint);
        $complaintForm->handleRequest($request);

        return $this->render('index/index.html.twig', [
            'pagination' => $pagination,
            'complaintForm' => $complaintForm->createView()
        ]);
    }

    /**
     * @Route("/top", name="top")
     * @param EntityManagerInterface $em
     * @param PaginatorInterface $paginator
     * @param Request $request
     * @return Response
     */
    public function top(EntityManagerInterface $em, PaginatorInterface $paginator, Request $request): Response
    {
        $postService = new PostService();
        $postList = $postService->getTopPostList($em);

        $complaint = new Complaint();
        $complaintForm = $this->createForm(ComplaintType::class, $complaint);
        $complaintForm->handleRequest($request);

        return $this->render('index/top.html.twig', [
            'postList' => $postList,
            'complaintForm' => $complaintForm->createView()
        ]);
    }


}
