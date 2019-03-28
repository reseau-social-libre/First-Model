<?php

declare(strict_types=1);

namespace App\Twig;

use App\Utils\Youtube;
use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

/**
 * Class YoutubeExtension
 */
class YoutubeExtension extends AbstractExtension
{

    /**
     * @var Youtube
     */
    protected $youtubeUtils;

    /**
     * YoutubeExtension constructor.
     *
     * @param Youtube $youtubeUtils
     */
    public function __construct(Youtube $youtubeUtils)
    {
        $this->youtubeUtils = $youtubeUtils;
    }

    /**
     * {@inheritdoc}
     */
    public function getFilters(): array
    {
        return [
            new TwigFilter('youtube', [$this, 'linkToPlayer'], ['is_safe' => ['html']]),
        ];
    }

    /**
     * Transforms the given Markdown content into HTML content.
     *
     * @param string $content
     *
     * @return string
     */
    public function linkToPlayer(string $content): string
    {
        $matches = $this->youtubeUtils->matchYoutubeUrl($content);

        if (!empty($matches)) {
            return $this->youtubeUtils->makeYoutubePlayer($matches[0], 'youtubePlayer');
        }

        return '';
    }

}
