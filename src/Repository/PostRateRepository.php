<?php

namespace App\Repository;

use App\Entity\PostRate;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method PostRate|null find($id, $lockMode = null, $lockVersion = null)
 * @method PostRate|null findOneBy(array $criteria, array $orderBy = null)
 * @method PostRate[]    findAll()
 * @method PostRate[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PostRateRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PostRate::class);
    }

    // /**
    //  * @return PostRate[] Returns an array of PostRate objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?PostRate
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
