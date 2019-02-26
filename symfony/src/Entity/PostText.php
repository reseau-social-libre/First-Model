<?php

declare(strict_types=1);

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class PostText
 *
 * @ORM\Entity()
 */
class PostText extends Post
{

    const POST_TYPE = 'Status';

    /**
     * @var string
     *
     * @ORM\Column(name="content_text", type="text")
     */
    protected $content;

    /**
     * @return string|null
     */
    public function getContent(): ?string
    {
        return $this->content;
    }

    /**
     * @param string $content
     *
     * @return PostText
     */
    public function setContent(string $content): self {
        $this->content = $content;

        return $this;
    }

}
