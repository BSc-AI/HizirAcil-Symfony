<?php

namespace App\Repository;

use App\Entity\Phpml;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;
/**
 * @method Phpml|null find($id, $lockMode = null, $lockVersion = null)
 * @method Phpml|null findOneBy(array $criteria, array $orderBy = null)
 * @method Phpml[]    findAll()
 * @method Phpml[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PhpmlRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Phpml::class);
    }

    // /**
    //  * @return Phpml[] Returns an array of Phpml objects
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
    public function findOneBySomeField($value): ?Phpml
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
