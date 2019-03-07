<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\UserStatus;

/**
 * @method UserStatus|null find($id, $lockMode = null, $lockVersion = null)
 * @method UserStatus|null findOneBy(array $criteria, array $orderBy = null)
 * @method UserStatus[]    findAll()
 * @method UserStatus[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserStatusRepository extends AbstractRepository
{

    /**
     * {@inheritdoc}
     */
    public function getClass(): string
    {
        return UserStatus::class;
    }

}
