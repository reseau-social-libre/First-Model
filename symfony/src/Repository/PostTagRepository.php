<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\PostTag;

/**
 * @method PostTag|null find($id, $lockMode = null, $lockVersion = null)
 * @method PostTag|null findOneBy(array $criteria, array $orderBy = null)
 * @method PostTag[]    findAll()
 * @method PostTag[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PostTagRepository extends AbstractRepository
{

    /**
     * {@inheritdoc}
     */
    public function getClass(): string
    {
        return PostTag::class;
    }

}
