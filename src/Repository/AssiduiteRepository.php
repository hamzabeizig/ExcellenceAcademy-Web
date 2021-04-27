<?php

namespace App\Repository;

use App\Entity\Assiduite;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Assiduite|null find($id, $lockMode = null, $lockVersion = null)
 * @method Assiduite|null findOneBy(array $criteria, array $orderBy = null)
 * @method Assiduite[]    findAll()
 * @method Assiduite[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AssiduiteRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Assiduite::class);
    }

    // /**
    //  * @return Assiduite[] Returns an array of Assiduite objects
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
    public function findOneBySomeField($value): ?Assiduite
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
