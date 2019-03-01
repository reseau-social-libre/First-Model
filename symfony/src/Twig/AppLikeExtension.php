<?php

declare(strict_types=1);

namespace App\Twig;

use App\Repository\PostLikeRepository;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class AppLikeExtension extends AbstractExtension
{

    /**
     * @var PostLikeRepository
     */
    private $postLikeRepository;

    /**
     * AppLikeExtension constructor.
     *
     * @param PostLikeRepository $postLikeRepository
     */
    public function __construct(PostLikeRepository $postLikeRepository)
    {
        $this->postLikeRepository = $postLikeRepository;
    }

    /**
     * {@inheritdoc}
     */
    public function getFunctions(): array
    {
        return [
            new TwigFunction('isUserLike', [$this, 'isUserLikePost']),
        ];
    }

    /**
     * Return true if the user has liked the post.
     *
     * @param int $postId
     * @param int $userId
     *
     * @return bool
     */
    public function isUserLikePost(int $postId, int $userId): bool
    {
        $postLike = $this->postLikeRepository->findOneBy([
            'user' => $userId,
            'post' => $postId,
        ]);

        return null !== $postLike;
    }

}
