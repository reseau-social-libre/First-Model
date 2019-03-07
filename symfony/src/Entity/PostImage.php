<?php

declare(strict_types=1);

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class PostImage
 *
 * @ORM\Entity()
 */
class PostImage extends PostText
{

    const POST_TYPE = 'Image';

    /**
     * @var Collection
     *
     * @ORM\OneToMany(targetEntity="ImagePost", mappedBy="post", cascade={"persist", "remove"})
     *
     * @Assert\Valid
     */
    protected $images;

    /**
     * PostImage constructor.
     */
    public function __construct()
    {
        parent::__construct();

        $this->images = new ArrayCollection();
    }

    /**
     * Add image
     *
     * @param ImagePost $image
     *
     * @return PostImage
     */
    public function addImage(ImagePost $image): self
    {
        if (null !== $image->getDocumentFile()) {
            if (!$this->images->contains($image)) {
                if (null == $image->getPost()) {
                    $image->setPost($this);
                }

                $this->images->add($image);
            }
        }

        return $this;
    }

    /**
     * Remove image
     *
     * @param ImagePost $image
     */
    public function removeImage(ImagePost $image)
    {
        $this->images->removeElement($image);
    }

    /**
     * Get the images collection.
     *
     * @return Collection
     */
    public function getImages(): Collection
    {
        return $this->images;
    }

}
