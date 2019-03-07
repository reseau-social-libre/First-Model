<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\UserInfo;

/**
 * @method UserInfo|null find($id, $lockMode = null, $lockVersion = null)
 * @method UserInfo|null findOneBy(array $criteria, array $orderBy = null)
 * @method UserInfo[]    findAll()
 * @method UserInfo[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserInfoRepository extends AbstractRepository
{

    /**
     * {@inheritdoc}
     */
    public function getClass(): string
    {
        return UserInfo::class;
    }

}
