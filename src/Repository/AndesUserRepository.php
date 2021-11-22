<?php

namespace App\Repository;

use App\Entity\AndesUser;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method AndesUser|null find($id, $lockMode = null, $lockVersion = null)
 * @method AndesUser|null findOneBy(array $criteria, array $orderBy = null)
 * @method AndesUser[]    findAll()
 * @method AndesUser[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AndesUserRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, AndesUser::class);
    }

    // /**
    //  * @return AndesUser[] Returns an array of AndesUser objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('a.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?AndesUser
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
