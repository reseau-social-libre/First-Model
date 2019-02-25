<?php

declare(strict_types=1);

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class PostLink.
 *
 * @ORM\Entity()
 */
class PostLink extends Post
{

    /**
     * @var string
     *
     * @ORM\Column(name="post_link", type="string", length=255)
     */
    protected $link;

    /**
     * @return string
     */
    public function getLink(): ?string
    {
        return $this->link;
    }

    /**
     * @param string $link
     */
    public function setLink(string $link)
    {
        $this->link = $link;
    }

}
