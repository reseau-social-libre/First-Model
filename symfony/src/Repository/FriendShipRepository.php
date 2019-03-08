<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\FriendShip;

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
}
