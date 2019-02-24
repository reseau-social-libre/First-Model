<?php

namespace App\Repository;

use App\Entity\PostTag;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method PostTag|null find($id, $lockMode = null, $lockVersion = null)
 * @method PostTag|null findOneBy(array $criteria, array $orderBy = null)
 * @method PostTag[]    findAll()
 * @method PostTag[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PostTagRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, PostTag::class);
    }

    // /**
    //  * @return PostTag[] Returns an array of PostTag objects
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
    public function findOneBySomeField($value): ?PostTag
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
