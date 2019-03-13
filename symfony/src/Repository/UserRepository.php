<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\User;

/**
 * Class UserRepository
 *
 * @method User|null find($id, $lockMode = null, $lockVersion = null)
 * @method User|null findOneBy(array $criteria, array $orderBy = null)
 * @method User[]    findAll()
 * @method User[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserRepository extends AbstractRepository
{

    /**
     * {@inheritdoc}
     */
    public function getClass(): string
    {
        return User::class;
    }

    /**
     * Find users by ids.
     *
     * @param array $ids
     *
     * @return mixed
     */
    public function findUsersFromIds(array $ids)
    {
        $qb = $this->createQueryBuilder('u')
                   ->where('u.id IN (:ids)')
                    ->setParameter('ids', $ids)
        ;

        return $qb->getQuery()->execute();
    }

    /**
     * Count total user in db.
     *
     * @return mixed
     */
    public function countTotalActiveUser()
    {
        $qb = $this->createQueryBuilder('u')
            ->select('count(u.id)')
            ->where('u.enabled = :enabled')
            ->setParameter('enabled', true)
        ;

        return $qb->getQuery()->getSingleScalarResult();
    }
}
