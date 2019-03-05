<?php

declare(strict_types=1);

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class UserProfilePicture
 *
 * @ORM\Entity()
 *
 * @Vich\Uploadable
 */
class UserProfilePicture extends AbstractDocument
{

    const DOCUMENT_TYPE = 'UserCover';

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    protected $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="userProfilePictures")
     * @ORM\JoinColumn(nullable=false)
     */
    protected $user;

    /**
     * @var File
     *
     * @Vich\UploadableField(mapping="user_profile", fileNameProperty="document")
     *
     * @Assert\File(
     *     maxSize = "8192k",
     *     mimeTypes = {"image/jpg", "image/jpeg", "image/png"},
     *     mimeTypesMessage = "jpg, png, jpeg only!"
     * )
     */
    protected $documentFile;

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
     * @return UserProfilePicture
     */
    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

}
