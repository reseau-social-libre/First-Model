<?php

namespace App\Repository;

use App\Entity\Relationship;

/**
 * @method Relationship|null find($id, $lockMode = null, $lockVersion = null)
 * @method Relationship|null findOneBy(array $criteria, array $orderBy = null)
 * @method Relationship[]    findAll()
 * @method Relationship[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class RelationshipRepository extends AbstractRepository
{

    /**
     * {@inheritdoc}
     */
    public function getClass(): string
    {
        return Relationship::class;
    }

    /**
     * Find all friend from a user.
     *
     * @param int $user
     *
     * @return mixed
     */
    public function findFriendsFrom(int $user)
    {
        $qb = $this->createQueryBuilder('r')
                   ->where('r.fromUser = :user')
                    ->select('r.toUser as id')
                   ->andWhere('r.type = :type')
                   ->andWhere('r.accepted = :accepted')
                   ->setParameter('user', $user)
                   ->setParameter('accepted', true)
                   ->setParameter('type', Relationship::TYPE_FRIEND)
        ;

        $result = $qb->getQuery()->execute();

        return $result;
    }

    /**
     * Find all friend from a user.
     *
     * @param int $user
     *
     * @return mixed
     */
    public function findFriendsTo(int $user)
    {
        $qb = $this->createQueryBuilder('r')
                   ->where('r.toUser = :user')
                   ->select('r.fromUser as id')
                   ->andWhere('r.type = :type')
                   ->andWhere('r.accepted = :accepted')
                   ->setParameter('user', $user)
                   ->setParameter('accepted', true)
                   ->setParameter('type', Relationship::TYPE_FRIEND)
        ;

        $result = $qb->getQuery()->execute();

        return $result;
    }

}
