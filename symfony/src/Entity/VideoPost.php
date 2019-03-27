<?php

declare(strict_types=1);

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class VideoPost
 *
 * @ORM\Entity()
 *
 * @Vich\Uploadable
 */
class VideoPost extends AbstractDocument
{

    const DOCUMENT_TYPE = 'Video';

    /**
     * @ORM\ManyToOne(targetEntity="PostVideo", inversedBy="videos")
     * @ORM\JoinColumn(nullable=true)
     */
    protected $post;

    /**
     * @var File
     *
     * @Vich\UploadableField(mapping="post_video", fileNameProperty="document")
     *
     * @Assert\File(
     *     maxSize = "196608k",
     *     mimeTypes = {"video/mp4"},
     *     mimeTypesMessage = "mp4 only!"
     * )
     */
    protected $documentFile;

    /**
     * Set post.
     *
     * @param Post $post
     *
     * @return VideoPost
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
