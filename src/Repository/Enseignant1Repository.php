<?php

namespace App\Repository;

use App\Entity\Enseignant1;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Enseignant1|null find($id, $lockMode = null, $lockVersion = null)
 * @method Enseignant1|null findOneBy(array $criteria, array $orderBy = null)
 * @method Enseignant1[]    findAll()
 * @method Enseignant1[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class Enseignant1Repository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Enseignant1::class);
    }

    // /**
    //  * @return Enseignant1[] Returns an array of Enseignant1 objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('e.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Enseignant1
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
