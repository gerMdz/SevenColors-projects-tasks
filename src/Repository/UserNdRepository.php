<?php

namespace App\Repository;

use App\Entity\UserNd;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method UserNd|null find($id, $lockMode = null, $lockVersion = null)
 * @method UserNd|null findOneBy(array $criteria, array $orderBy = null)
 * @method UserNd[]    findAll()
 * @method UserNd[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserNdRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, UserNd::class);
    }

    // /**
    //  * @return UserNd[] Returns an array of UserNd objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('u.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?UserNd
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
