<?php

declare(strict_types=1);

namespace App\Service;

use App\Entity\PostLike;
use App\Entity\PostLive;
use App\Repository\PostLikeRepository;

/**
 * Class PostLikeService
 */
class PostLikeService
{

    /**
     * @var PostLikeRepository
     */
    protected $postLikeRepository;

    /**
     * PostLikeService constructor.
     *
     * @param PostLikeRepository $postLikeRepository
     */
    public function __construct(PostLikeRepository $postLikeRepository)
    {
        $this->postLikeRepository = $postLikeRepository;
    }

    /**
     * Find post like by criteria.
     *
     * @param array $criteria
     *
     * @return PostLike|null
     */
    public function findOneByCriteria(array $criteria): ?PostLike
    {
        return $this->postLikeRepository->findOneBy($criteria);
    }

    /**
     * Remove postLike from db.
     *
     * @param $postLike
     */
    public function removePostLike(PostLike $postLike)
    {
        $this->postLikeRepository->removeAndFlush($postLike);
    }

    /**
     * Persist and flush to db.
     *
     * @param PostLike $postLike
     */
    public function savePostLike(PostLike $postLike)
    {
        $this->postLikeRepository->persistAndFlush($postLike);
    }

    /**
     * @param PostLive $post
     */
    public function savePostLive(PostLive $post)
    {
        $this->postLikeRepository->persistAndFlush($post);
    }
}
