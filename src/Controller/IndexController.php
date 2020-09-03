<?php

namespace App\Controller;

use App\Entity\Complaint;
use App\Entity\Post;
use App\Form\ComplaintType;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Predis\Client;
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
        $cacheKey = 'cache-first-page';
        $cacheTTL = 600;



        $paginatorLimit = 10;

        $redis = new Client();

        $pagination = null;

        $postRepository = $em->getRepository(Post::class);

        $postQuery = $postRepository->getPostList();

        $paginatorPage = $request->query->getInt('page', 1);

        if ($paginatorPage === 1) {
            $pagination = $redis->get($cacheKey);
            if (!$pagination) {

                $pagination = $paginator->paginate(
                    $em->createQuery($postQuery->getDQL()),
                    $paginatorPage,
                    $paginatorLimit
                );

                $redis->set($cacheKey, serialize($pagination));
                $redis->expire($cacheKey, $cacheTTL);

            } else {
                $pagination = unserialize($pagination);
            }
        } else {
            $pagination = $paginator->paginate(
                $em->createQuery($postQuery->getDQL()),
                $paginatorPage,
                $paginatorLimit
            );
        }

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
        $redis = new Client();

        $postList = $redis->get($cacheKey);

        if (!$postList) {

            $postRepository = $em->getRepository(Post::class);

            $postList = $postRepository->getTopPostList()->getResult();

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
