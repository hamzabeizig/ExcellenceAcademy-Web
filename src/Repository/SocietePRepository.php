<?php

namespace App\Repository;

use App\Entity\SocieteP;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method SocieteP|null find($id, $lockMode = null, $lockVersion = null)
 * @method SocieteP|null findOneBy(array $criteria, array $orderBy = null)
 * @method SocieteP[]    findAll()
 * @method SocieteP[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SocietePRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, SocieteP::class);
    }

    // /**
    //  * @return SocieteP[] Returns an array of SocieteP objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('s.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?SocieteP
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
