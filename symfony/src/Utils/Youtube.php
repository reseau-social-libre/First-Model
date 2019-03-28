<?php

declare(strict_types=1);

namespace App\Utils;

/**
 * Class Youtube
 */
class Youtube
{

    const REGEX = '#(?<=(?:v|i)=)[a-zA-Z0-9-_]+|(?<=(?:v|i)\/)[^&?\n]+|(?<=embed\/)[^"&?\n]+|(?<=‌​(?:v|i)=)[^&?\n]+|(?<=youtu.be\/)[^&?\n]+#';

    /**
     * Grab youtube video id's.
     *
     * @param string $content
     *
     * @return array
     *  Array of YT id's
     */
    public function matchYoutubeUrl(string $content): array {
        preg_match(self::REGEX, $content, $matches);

        return $matches;
    }

    /**
     * Make a youtube player.
     *
     * @param string $vidId
     * @param string $cssClass
     *
     * @return string
     */
    public function makeYoutubePlayer(string $vidId, string $cssClass): string {
        return '<iframe class="'.$cssClass.'" width="100%" height="315" src="https://www.youtube.com/embed/'.$vidId.'"></iframe>';
    }

}