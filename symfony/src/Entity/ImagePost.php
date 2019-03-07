<?php

declare(strict_types=1);

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class ImagePost
 *
 * @ORM\Entity()
 *
 * @Vich\Uploadable
 */
class ImagePost extends AbstractDocument
{

    const DOCUMENT_TYPE = 'Image';

    /**
     * @ORM\ManyToOne(targetEntity="PostImage", inversedBy="images")
     * @ORM\JoinColumn(nullable=true)
     */
    protected $post;

    /**
     * @var File
     *
     * @Vich\UploadableField(mapping="post_image", fileNameProperty="document")
     *
     * @Assert\File(
     *     maxSize = "8192k",
     *     mimeTypes = {"image/jpg", "image/jpeg", "image/png"},
     *     mimeTypesMessage = "jpg, png, jpeg only!"
     * )
     */
    protected $documentFile;

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
