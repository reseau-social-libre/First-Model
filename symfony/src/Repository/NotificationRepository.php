<?php

namespace App\Repository;

use App\Entity\Notification;
use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Notification|null find($id, $lockMode = null, $lockVersion = null)
 * @method Notification|null findOneBy(array $criteria, array $orderBy = null)
 * @method Notification[]    findAll()
 * @method Notification[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class NotificationRepository extends AbstractRepository
{

    /**
     * {@inheritdoc}
     */
    public function getClass(): string
    {
        return Notification::class;
    }

    /**
     * @param \App\Entity\User $user
     *
     * @return mixed
     */
    public function findUnreadNotificationByUser(User $user)
    {
        $qb = $this->createQueryBuilder('n')
                   ->innerJoin('n.userSender', 'u')
                   ->addSelect('u')
                   ->where('n.user = :user')
                   ->andWhere('n.seen = :seen')
                   ->orderBy('n.createdAt', 'DESC')
                   ->setParameter('user', $user)
                   ->setParameter('seen', false)
        ;

        $result = $qb->getQuery()->getResult();

        return $result;
    }
}
