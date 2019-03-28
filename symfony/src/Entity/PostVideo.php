<?php

declare(strict_types=1);

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class PostVideo
 *
 * @ORM\Entity()
 */
class PostVideo extends PostText
{

    const POST_TYPE = 'Video';

    /**
     * @var Collection
     *
     * @ORM\OneToMany(targetEntity="VideoPost", mappedBy="post", cascade={"persist", "remove"})
     *
     * @Assert\Valid
     */
    protected $videos;

    /**
     * PostVideo constructor.
     */
    public function __construct()
    {
        parent::__construct();

        $this->videos = new ArrayCollection();
    }

    /**
     * Add video
     *
     * @param VideoPost $video
     *
     * @return PostVideo
     */
    public function addVideo(VideoPost $video): self
    {
        if (null !== $video->getDocumentFile()) {
            if (!$this->videos->contains($video)) {
                if (null == $video->getPost()) {
                    $video->setPost($this);
                }

                $this->videos->add($video);
            }
        }

        return $this;
    }

    /**
     * Remove video
     *
     * @param VideoPost $video
     */
    public function removeVideo(VideoPost $video)
    {
        $this->videos->removeElement($video);
    }

    /**
     * Get the videos collection.
     *
     * @return Collection
     */
    public function getVideos(): Collection
    {
        return $this->videos;
    }
}
