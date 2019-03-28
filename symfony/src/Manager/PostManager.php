<?php

declare(strict_types=1);

namespace App\Manager;

use App\Entity\Post;
use App\Entity\PostLike;
use App\Entity\PostLive;
use App\Entity\User;
use App\Service\PostLikeService;
use App\Service\PostService;
use Pagerfanta\Pagerfanta;

/**
 * Class PostManager
 */
class PostManager
{

    /**
     * @var PostService
     */
    protected $postService;

    /**
     * @var PostLikeService
     */
    protected $postLikeService;

    /**
     * PostManager constructor.
     *
     * @param PostService     $postService
     * @param PostLikeService $postLikeService
     */
    public function __construct(
        PostService $postService,
        PostLikeService $postLikeService
    ) {
        $this->postService = $postService;
        $this->postLikeService = $postLikeService;
    }

    /**
     * Get wall feed paginated.
     *
     * @param User|null $user
     * @param int       $page
     * @param string    $locale
     *
     * @return Pagerfanta
     */
    public function getWallPaginated(User $user = null, int $page, string $locale = ''): Pagerfanta
    {
        if ($user) {
            return $this->postService->getWallUserPaginated($user, $page);
        }

        return $this->postService->getWallPaginated($locale, $page);
    }

    /**
     * Get a post by it's id.
     *
     * @param int $id
     *
     * @return Post|null
     *
     * @throws \Exception
     */
    public function getPostById(int $id): ?Post
    {
        if (0 == $id) {
            throw new \Exception(
                sprintf(
                    'Parameter id with value %s is not a valid argument',
                    $id
                )
            );
        }

        return $this->postService->findPostById($id);
    }

    /**
     * Get post like.
     *
     * @param int $user
     * @param int $post
     *
     * @return PostLike|null
     *
     * @throws \Exception
     */
    public function getPostLike(int $user, int $post): ?PostLike
    {
        if (null == $post || null == $user) {
            throw new \Exception('Arguments can not be null');
        }

        return $this->postLikeService->findOneByCriteria(
            [
                'post' => $post,
                'user' => $user,
            ]
        );
    }

    /**
     * Remove a post like.
     *
     * @param PostLike $postLike
     */
    public function removePostLike(PostLike $postLike)
    {
        $this->postLikeService->removePostLike($postLike);
    }

    /**
     * Add post like.
     *
     * @param PostLike $postLike
     */
    public function addPostLike(PostLike $postLike)
    {
        $this->postLikeService->savePostLike($postLike);
    }

    /**
     * Create new post of type live.
     *
     * @param PostLive $post
     */
    public function createPostLive(PostLive $post)
    {
        $this->postLikeService->savePostLive($post);
    }

}
