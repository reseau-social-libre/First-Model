<?php

declare(strict_types=1);

namespace App\Repository;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * Class AbstractRepository
 */
abstract class AbstractRepository extends ServiceEntityRepository
    implements RepositoryInterface
{
    /**
     * @inheritdoc
     */
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, $this->getClass());
    }

    /**
     * @param mixed $entity
     */
    public function removeAndFlush($entity)
    {
        $em = $this->getEntityManager();
        $em->remove($entity);
        $em->flush();
    }

    /**
     * @param mixed $entity
     */
    public function persistAndFlush($entity)
    {
        $em = $this->getEntityManager();

        $em->persist($entity);
        $em->flush();
    }

}
