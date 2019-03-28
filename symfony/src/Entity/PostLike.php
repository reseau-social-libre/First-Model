<?php

declare(strict_types=1);

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use JMS\Serializer\Annotation as Serializer;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * Class PostLike
 *
 * @ORM\Table(name="post_like",uniqueConstraints={@ORM\UniqueConstraint(name="uniq_post_like", columns={"user_id", "post_id"})})
 * @ORM\Entity(repositoryClass="App\Repository\PostLikeRepository")
 *
 * @Serializer\ExclusionPolicy("All")
 *
 * @UniqueEntity(fields={"user","post"})
 */
class PostLike
{

    use TimestampableEntity;

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     *
     * @Serializer\Expose()
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User")
     * @ORM\JoinColumn(nullable=false)
     *
     * @Serializer\Expose()
     */
    private $user;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Post", inversedBy="likes")
     * @ORM\JoinColumn(nullable=false)
     */
    private $post;

    /**
     * Get the id.
     *
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * Get the user.
     *
     * @return User|null
     */
    public function getUser(): ?User
    {
        return $this->user;
    }

    /**
     * Set the user.
     *
     * @param User|null $user
     *
     * @return PostLike
     */
    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get the post.
     *
     * @return Post|null
     */
    public function getPost(): ?Post
    {
        return $this->post;
    }

    /**
     * Set the post.
     *
     * @param Post|null $post
     *
     * @return PostLike
     */
    public function setPost(?Post $post): self
    {
        $this->post = $post;

        return $this;
    }

}
