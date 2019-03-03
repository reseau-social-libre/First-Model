<?php

declare(strict_types=1);

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class ImagePost
 *
 * @ORM\Entity()
 */
class ImagePost extends AbstractDocument
{

    const POST_TYPE = 'Image';

    /**
     * @ORM\ManyToOne(targetEntity="PostImage", inversedBy="images")
     * @ORM\JoinColumn(nullable=false)
     */
    protected $post;

    /**
     * Set post.
     *
     * @param Post $post
     *
     * @return ImagePost
     */
    public function setPost(?Post $post = null): self
    {
        $this->post = $post;

        return $this;
    }

    /**
     * Get post.
     *
     * @return Post
     */
    public function getPost()
    {
        return $this->post;
    }

}
