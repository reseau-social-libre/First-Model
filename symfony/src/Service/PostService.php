<?php

declare(strict_types=1);

namespace App\Service;

use App\Entity\Post;
use App\Entity\User;
use App\Repository\PostRepository;
use Pagerfanta\Pagerfanta;
use Symfony\Component\DependencyInjection\Exception\ParameterNotFoundException;

/**
 * Class PostService
 */
class PostService
{

    /**
     * @var PostRepository
     */
    protected $postRepository;

    /**
     * PostService constructor.
     *
     * @param PostRepository $postRepository
     */
    public function __construct(PostRepository $postRepository)
    {
        $this->postRepository = $postRepository;
    }

    /**
     * Get the user post feed paginated.
     *
     * @param User $user
     * @param int  $page
     *
     * @return Pagerfanta
     */
    public function getWallUserPaginated(User $user, int $page): Pagerfanta
    {
        if (null == $user) {
            throw new ParameterNotFoundException('User entity must be provided');
        }

        return $this->postRepository->findLatestByUser($user->getId(), $page);
    }

    /**
     * Get the main feed by local.
     *
     * @param string $locale
     * @param int    $page
     *
     * @return Pagerfanta
     */
    public function getWallPaginated(string $locale, int $page): Pagerfanta
    {
        if (empty($locale)) {
            return $this->postRepository->findAllLatest($page);
        }

        return $this->postRepository->findLatest($locale, $page);
    }

    /**
     * Find post by id.
     * @param $id
     *
     * @return Post|null
     */
    public function findPostById($id): ?Post
    {
        return $this->postRepository->find($id);
    }

}
