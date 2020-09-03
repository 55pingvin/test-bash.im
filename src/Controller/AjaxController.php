<?php

namespace App\Controller;


use App\Entity\Complaint;
use App\Entity\Post;
use App\Entity\PostRate;
use App\Form\ComplaintType;
use App\Form\PostType;
use App\Repository\PostRateRepository;
use App\Repository\PostRepository;
use App\Services\ComplaintService;
use App\Services\RateService;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use phpDocumentor\Reflection\Types\False_;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;


class AjaxController extends AbstractController
{
    /**
     * @Route("/rate/{type}/{post}", name="post_rate")
     * @param Request $request
     * @param Post $post
     * @param string $type
     * @return Response
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function ratePost(Request $request, Post $post, string $type): Response
    {
        $result['success'] = false;
        $result['message'] = 'Вы голосовали ранее';

        $ipv4 = $request->getClientIp();

        $postRateRepository = $this->getDoctrine()->getRepository(PostRate::class);
        $postRepository = $this->getDoctrine()->getRepository(Post::class);

        $rateService = new RateService($postRateRepository, $postRepository,$post, $type, $ipv4);

        if($score = $rateService->rate()) {
            $result['message'] = 'Ваш голос учтен';
            $result['success'] = true;
            $result['score'] = $score;
        }

        return new JsonResponse($result);
    }


    /**
     * @Route("/complaint/post/{post}", name="post_complaint", requirements={"post_id"="\d+"})
     * @param Request $request
     * @param Post $post
     * @return Response
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function complaint(Request $request, Post $post): Response
    {
        $result['success'] = false;
        $result['message'] = 'Ошибка отпрвки жалобы';

        $complaintRepository = $this->getDoctrine()->getRepository(Complaint::class);

        $text = $request->request->get('text');

        if ($post && $text) {
            $complaintService = new ComplaintService($complaintRepository, $post);

            if ($complaintService->save($text)) {
                $result['message'] = 'Жалоба отправлена';
                $result['success'] = true;
            }
        }

        return new JsonResponse($result);
    }
}