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

        $pagination = null;
        $postService = new PostService($em);

        $pagination = $postService->getPostList($paginator, $request);

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

        $cacheKey = 'cache-top-page';
        $cacheTTL = 600;
        $redis = new \Predis\Client();

        $postList = $redis->get($cacheKey);

        if (!$postList) {

            $postService = new PostService($em);

            $postList = $postService->getTopPostList();

            $redis->set($cacheKey, serialize($postList));
            $redis->expire($cacheKey, $cacheTTL);

        } else {
            $postList = unserialize($postList);
        }

        $complaint = new Complaint();
        $complaintForm = $this->createForm(ComplaintType::class, $complaint);
        $complaintForm->handleRequest($request);

        return $this->render('index/top.html.twig', [
            'postList' => $postList,
            'complaintForm' => $complaintForm->createView()
        ]);
    }


}
