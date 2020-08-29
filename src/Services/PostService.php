<?php


namespace App\Services;


use App\Entity\Post;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;

class PostService
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /** Метод получения постов
     * @param $em
     * @param $paginator
     * @param $request
     * @return mixed
     */
    public function getPostList(PaginatorInterface $paginator, Request $request)
    {
        $postRepository = $this->entityManager->getRepository(Post::class);

        $postQuery = $postRepository->getPostList();

        $query = $this->entityManager->createQuery($postQuery->getDQL());

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
    public function getTopPostList(int $count = 10)
    {
        $postRepository = $this->entityManager->getRepository(Post::class);

        return $postRepository->getTopPostList()->getResult();

    }
}