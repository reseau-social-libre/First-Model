<?php

declare(strict_types=1);

namespace App\Manager;

use App\Entity\User;
use App\Service\PostService;

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
     * PostManager constructor.
     *
     * @param PostService $postService
     */
    public function __construct(PostService $postService)
    {
        $this->postService = $postService;
    }

    /**
     * Get wall feed paginated.
     *
     * @param User|null $user
     * @param int       $page
     * @param string    $locale
     *
     * @return \Pagerfanta\Pagerfanta
     */
    public function getWallPaginated(
        User $user = null,
        int $page,
        string $locale = ''
    ) {
        if ($user) {
            return $this->postService->getWallUserPaginated($user, $page);
        }

        return $this->postService->getWallPaginated($locale, $page);
    }

}
