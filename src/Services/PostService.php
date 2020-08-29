<?php


namespace App\Services;


use App\Entity\Post;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;

class PostService
{
    /** Метод получения постов
     * @param $em
     * @param $paginator
     * @param $request
     * @return mixed
     */
    public function getPostList(EntityManagerInterface $em, PaginatorInterface $paginator, Request $request)
    {
        $postRepository = $em->getRepository(Post::class);

        $postQuery = $postRepository->getPostList();

        $query = $em->createQuery($postQuery->getDQL());

        return $paginator->paginate(
            $query,
            $request->query->getInt('page', 1),
            10
        );
    }


    /** Метод получения топ постов
     * @param $em
     * @param int $count
     * @return mixed
     */
    public function getTopPostList(EntityManagerInterface $em, int $count = 10)
    {
        $postRepository = $em->getRepository(Post::class);

        return $postRepository->getTopPostList()->getResult();

    }
}