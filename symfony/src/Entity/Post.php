<?php

declare(strict_types=1);

namespace App\Entity;

use App\Traits\SluggableTrait;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Timestampable\Traits\TimestampableEntity;

/**
 * Class Post
 *
 * @ORM\Entity(repositoryClass="App\Repository\PostRepository")
 * @ORM\InheritanceType("SINGLE_TABLE")
 * @ORM\DiscriminatorColumn(name="post_type", type="string", length=20)
 * @ORM\DiscriminatorMap({
 *     "Text"="PostText",
 *     "Image"="PostImage",
 *     "Video"="PostVideo",
 *     "Link"="PostLink",
 *     "Live"="PostLive",
 * })
 */
abstract class Post
{

    use TimestampableEntity, SluggableTrait;

    const NUM_POST_PER_PAGE = 20;

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    protected $id;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\PostComment", mappedBy="post", cascade={"persist", "remove"})
     */
    protected $comments;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="posts")
     * @ORM\JoinColumn(nullable=false)
     */
    protected $user;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\PostLike", mappedBy="post", cascade={"persist", "remove"})
     */
    protected $likes;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\PostTag", mappedBy="posts", cascade={"persist", "remove"})
     */
    protected $postTags;

    /**
     * @ORM\Column(name="locale", type="string", length=4)
     */
    protected $locale;

    /**
     * Post constructor.
     */
    public function __construct()
    {
        $this->comments = new ArrayCollection();
        $this->likes = new ArrayCollection();
        $this->postTags = new ArrayCollection();
    }

    /**
     * Get the post id.
     *
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * Get the post Comments collection.
     *
     * @return Collection|PostComment[]
     */
    public function getComments(): Collection
    {
        return $this->comments;
    }

    /**
     * Add a Comment to the post.
     *
     * @param PostComment $comment
     *
     * @return Post
     */
    public function addComment(PostComment $comment): self
    {
        if (!$this->comments->contains($comment)) {
            $this->comments[] = $comment;
            $comment->setPost($this);
        }

        return $this;
    }

    /**
     * Remove a comment from the post.
     *
     * @param PostComment $comment
     *
     * @return Post
     */
    public function removeComment(PostComment $comment): self
    {
        if ($this->comments->contains($comment)) {
            $this->comments->removeElement($comment);
            // set the owning side to null (unless already changed)
            if ($comment->getPost() === $this) {
                $comment->setPost(null);
            }
        }

        return $this;
    }

    /**
     * Get the post User.
     *
     * @return User|null
     */
    public function getUser(): ?User
    {
        return $this->user;
    }

    /**
     * Set the post User.
     *
     * @param User|null $user
     *
     * @return Post
     */
    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get the post Like collection.
     *
     * @return Collection|PostLike[]
     */
    public function getLikes(): Collection
    {
        return $this->likes;
    }

    /**
     * Add a Like to the post.
     *
     * @param PostLike $like
     *
     * @return Post
     */
    public function addLike(PostLike $like): self
    {
        if (!$this->likes->contains($like)) {
            $this->likes[] = $like;
            $like->setPost($this);
        }

        return $this;
    }

    /**
     * Remove a like from the post Like collection.
     *
     * @param PostLike $like
     *
     * @return Post
     */
    public function removeLike(PostLike $like): self
    {
        if ($this->likes->contains($like)) {
            $this->likes->removeElement($like);
            // set the owning side to null (unless already changed)
            if ($like->getPost() === $this) {
                $like->setPost(null);
            }
        }

        return $this;
    }

    /**
     * Get the post Like collection.
     *
     * @return Collection|PostTag[]
     */
    public function getPostTags(): Collection
    {
        return $this->postTags;
    }

    /**
     * Add a postTag to the post.
     *
     * @param PostTag $postTag
     *
     * @return Post
     */
    public function addPostTag(PostTag $postTag): self
    {
        if (!$this->postTags->contains($postTag)) {
            $this->postTags[] = $postTag;
            $postTag->addPost($this);
        }

        return $this;
    }

    /**
     * Remove a PostTag from the post.
     *
     * @param PostTag $postTag
     *
     * @return Post
     */
    public function removePostTag(PostTag $postTag): self
    {
        if ($this->postTags->contains($postTag)) {
            $this->postTags->removeElement($postTag);
            $postTag->removePost($this);
        }

        return $this;
    }

    /**
     * Get the post type.
     *
     * @return mixed
     */
    public static function getpost_type() {
        $c = get_called_class();

        return $c::POST_TYPE;
    }

    /**
     * Get the post locale.
     *
     * @return mixed
     */
    public function getLocale()
    {
        return $this->locale;
    }

    /**
     * Set the post locale.
     *
     * @param mixed $locale
     *
     * @return Post
     */
    public function setLocale($locale)
    {
        $this->locale = $locale;

        return $this;
    }

}
