<?php

namespace App\Repository;

use App\Entity\ProBundles;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method ProBundles|null find($id, $lockMode = null, $lockVersion = null)
 * @method ProBundles|null findOneBy(array $criteria, array $orderBy = null)
 * @method ProBundles[]    findAll()
 * @method ProBundles[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProBundlesRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ProBundles::class);
    }

    // /**
    //  * @return ProBundles[] Returns an array of ProBundles objects
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
    public function findOneBySomeField($value): ?ProBundles
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
