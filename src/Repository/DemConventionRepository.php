<?php

namespace App\Repository;

use App\Entity\DemConvention;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method DemConvention|null find($id, $lockMode = null, $lockVersion = null)
 * @method DemConvention|null findOneBy(array $criteria, array $orderBy = null)
 * @method DemConvention[]    findAll()
 * @method DemConvention[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DemConventionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, DemConvention::class);
    }

    // /**
    //  * @return DemConvention[] Returns an array of DemConvention objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('d')
            ->andWhere('d.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('d.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?DemConvention
    {
        return $this->createQueryBuilder('d')
            ->andWhere('d.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
