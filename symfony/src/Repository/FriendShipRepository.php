<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\FriendShip;
use App\Entity\User;

/**
 * @method FriendShip|null find($id, $lockMode = null, $lockVersion = null)
 * @method FriendShip|null findOneBy(array $criteria, array $orderBy = null)
 * @method FriendShip[]    findAll()
 * @method FriendShip[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class FriendShipRepository extends AbstractRepository
{

    /**
     * {@inheritdoc}
     */
    public function getClass(): string
    {
        return FriendShip::class;
    }

    /**
     * Find all friends.
     *
     * @param User     $user
     * @param int|null $limit
     *
     * @return mixed
     */
    public function findAllFriends(User $user, int $limit = null)
    {
        $qb = $this->getEntityManager()->createQueryBuilder();

        $qb->select('u')
           ->from('App:User', 'u')
           ->leftJoin('u.friends', 'f')
           ->where('f.friendWithMe = :user')
           ->andWhere('f.accepted = :accepted')
           ->andWhere('f.friendShipType = :type')
           ->orderBy('f.createdAt', 'DESC')
           ->setParameter('user', $user)
           ->setParameter('accepted', true)
           ->setParameter('type', FriendShip::TYPE_FRIEND);

        if ($limit) {
            $qb->setMaxResults($limit);
        }

        $result = $qb->getQuery()->getResult();

        return $result;
    }

    /**
     * Find the pending friend request.
     *
     * @param User $user
     *
     * @return mixed
     */
    public function findPendingFriendRequest(User $user)
    {
        $qb = $this->createQueryBuilder('f')
                   ->join('f.friend', 'u')
                   ->where('f.friendWithMe = :user')
                   ->addSelect('u')
                   ->andWhere('f.accepted = :accepted')
                   ->andWhere('f.friendShipType = :type')
                   ->orderBy('f.createdAt', 'DESC')
                   ->setParameter('user', $user)
                   ->setParameter('accepted', false)
                   ->setParameter('type', FriendShip::TYPE_FRIEND);
        ;

        $result = $qb->getQuery()->getResult();

        return $result;
    }

    /**
     * Find followers.
     *
     * @param User     $user
     * @param int|null $limit
     *
     * @return mixed
     */
    public function findFollowers(User $user, int $limit = null)
    {
        $qb = $this->getEntityManager()->createQueryBuilder();

        $qb->select('u')
           ->from('App:User', 'u')
           ->leftJoin('u.friends', 'f')
           ->where('f.friendWithMe = :user')
           ->andWhere('f.friendShipType = :type')
           ->orderBy('f.createdAt', 'DESC')
           ->setParameter('user', $user)
           ->setParameter('type', FriendShip::TYPE_FOLLOW);

        if ($limit) {
            $qb->setMaxResults($limit);
        }

        $result = $qb->getQuery()->getResult();

        return $result;
    }

    /**
     * Find the following users.
     *
     * @param User     $user
     * @param int|null $limit
     *
     * @return mixed
     */
    public function findFollowing(User $user, int $limit = null)
    {
        $qb = $this->getEntityManager()->createQueryBuilder();
        $qb->select('u')
           ->from('App:User', 'u')
           ->leftJoin('u.friendsWithMe', 'f')
           ->where('f.friend = :user')
           ->andWhere('f.friendShipType = :type')
           ->orderBy('f.createdAt', 'DESC')
           ->setParameter('user', $user)
           ->setParameter('type', FriendShip::TYPE_FOLLOW);

        if ($limit) {
            $qb->setMaxResults($limit);
        }

        $result = $qb->getQuery()->getResult();

        return $result;
    }
}
