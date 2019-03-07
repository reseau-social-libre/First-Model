<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\PostComment;

/**
 * @method PostComment|null find($id, $lockMode = null, $lockVersion = null)
 * @method PostComment|null findOneBy(array $criteria, array $orderBy = null)
 * @method PostComment[]    findAll()
 * @method PostComment[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PostCommentRepository extends AbstractRepository
{

    /**
     * {@inheritdoc}
     */
    public function getClass(): string
    {
        return PostComment::class;
    }

}
