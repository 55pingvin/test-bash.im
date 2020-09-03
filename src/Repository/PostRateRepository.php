<?php

namespace App\Repository;

use App\Entity\PostRate;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
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

    /**
     * Метод сохранения PostRate
     * @param PostRate $postRate
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function save(PostRate $postRate): void
    {
        $this->_em->persist($postRate);
        $this->_em->flush();
    }
}
