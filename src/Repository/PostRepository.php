<?php

namespace App\Repository;

use App\Entity\Post;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Query;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Post|null find($id, $lockMode = null, $lockVersion = null)
 * @method Post|null findOneBy(array $criteria, array $orderBy = null)
 * @method Post[]    findAll()
 * @method Post[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PostRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Post::class);
    }

    /** Запрос для полчения всех постов с сортровкой по убыванию
     * @param int $count
     * @return Query
     */
    public function getPostList(int $count = 10)
    {
        return $this->createQueryBuilder('p')
            ->orderBy('p.id', 'DESC')
            ->getQuery();
    }

    /** Запрос для полчения топ постов
     * @param int $count
     * @return Query
     */
    public function getTopPostList(int $count = 10)
    {
        return $this->createQueryBuilder('p')
            ->orderBy('p.rate', 'DESC')
            ->setMaxResults($count)
            ->getQuery();
    }

}
