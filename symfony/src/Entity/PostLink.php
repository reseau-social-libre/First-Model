<?php

declare(strict_types=1);

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class PostLink
 *
 * @ORM\Entity()
 */
class PostLink extends Post
{

    const POST_TYPE = 'Link';

    /**
     * @var string
     *
     * @ORM\Column(name="post_link", type="string", length=255)
     */
    protected $link;

    /**
     * Get the link.
     *
     * @return string
     */
    public function getLink(): ?string
    {
        return $this->link;
    }

    /**
     * Set the link.
     *
     * @param string $link
     */
    public function setLink(string $link)
    {
        $this->link = $link;
    }

}
