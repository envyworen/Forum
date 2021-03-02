<?php

namespace App\Repository;

use App\Entity\Castle;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Castle|null find($id, $lockMode = null, $lockVersion = null)
 * @method Castle|null findOneBy(array $criteria, array $orderBy = null)
 * @method Castle[]    findAll()
 * @method Castle[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CastleRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Castle::class);
    }

    // /**
    //  * @return Castle[] Returns an array of Castle objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('c.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Castle
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
