<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\PostLike;

/**
 * @method PostLike|null find($id, $lockMode = null, $lockVersion = null)
 * @method PostLike|null findOneBy(array $criteria, array $orderBy = null)
 * @method PostLike[]    findAll()
 * @method PostLike[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PostLikeRepository extends AbstractRepository
{
    /**
     * {@inheritdoc}
     */
    public function getClass(): string
    {
        return PostLike::class;
    }
}
