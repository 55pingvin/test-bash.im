<?php

namespace App\Controller;


use App\Entity\Post;
use App\Entity\PostRate;
use App\Form\PostType;
use App\Repository\PostRateRepository;
use App\Repository\PostRepository;
use phpDocumentor\Reflection\Types\False_;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;


class AjaxController extends AbstractController
{
    /**
     * @Route("/rate", name="post_rate")
     * @param Request $request
     * @return Response
     */
    public function ratePost(Request $request): Response
    {
        $result['success'] = false;
        $result['message'] = 'Вы голосовали ранее';

        $entityManager = $this->getDoctrine()->getManager();

        $postId = $request->request->get('post_id');
        $type = $request->request->get('type');
        $ipv4 = $request->getClientIp();

        $postRateRepository = $entityManager->getRepository(PostRate::class);
        $postRate = $postRateRepository->findOneBy(
            [
                'post' => $postId,
                'ipv4' => $ipv4 // Такая проверка будет печальной если пользователь сидит за NAT один проголосует, а другие нет
            ]
        );

        if (!$postRate) {
            $postRepository = $entityManager->getRepository(Post::class);
            $post = $postRepository->find($postId);

            if ($post && $type) {

                $rate = ($type === 'like') ? 1 : -1;

                $postRate = new PostRate();
                $postRate->setPost($post);
                $postRate->setRate($rate);
                $postRate->setIpv4($ipv4);

                $post->setRate($rate);

                $entityManager->persist($postRate);
                $entityManager->persist($post);
                $entityManager->flush();


                $result['message'] = 'Ваш голос учтен';
                $result['success'] = true;
                $result['score'] = $post->getRate();

            }
        }

        return new JsonResponse($result);
    }
}