<?php

declare(strict_types=1);

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

/**
 * @ORM\Entity(repositoryClass="App\Repository\DocumentRepository")
 * @ORM\Table(name="document")
 * @ORM\InheritanceType("SINGLE_TABLE")
 * @ORM\DiscriminatorColumn(name="document_type", type="string", length=20)
 * @ORM\DiscriminatorMap({
 *     "Image"="ImagePost",
 *     "UserCover"="UserCoverPicture",
 *     "UserProfile"="UserProfilePicture"
 * })
 *
 * @Vich\Uploadable
 */
abstract class AbstractDocument
{

    use TimestampableEntity;

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    protected $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=false)
     */
    protected $document;

    /**
     * This property must be override by child class.
     * The mapping must specified to a valid vich config mapping.
     *
    * @Vich\UploadableField(mapping="to_override", fileNameProperty="document")
     *
     * @var File
     */
    protected $documentFile;

    /**
     * AbstractDocument constructor.
     */
    public function __construct()
    {
        $this->createdAt = new \DateTime();
    }

    /**
     * Get the document id.
     *
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * Get the document path name.
     *
     * @return null|string
     */
    public function getDocument(): ?string
    {
        return $this->document;
    }

    /**
     * Set the document path name.
     *
     * @param string $document
     *
     * @return $this
     */
    public function setDocument(?string $document): self
    {
        $this->document = $document;

        return $this;
    }

    /**
     * @return File|null
     */
    public function getDocumentFile(): ?File
    {
        return $this->documentFile;
    }

    /**
     * If manually uploading a file (i.e. not using Symfony Form) ensure an instance
     * of 'UploadedFile' is injected into this setter to trigger the  update. If this
     * bundle's configuration parameter 'inject_on_load' is set to 'true' this setter
     * must be able to accept an instance of 'File' as the bundle will inject one here
     * during Doctrine hydration.
     *
     * @param File|UploadedFile $file
     *
     * @return AbstractDocument
     */
    public function setDocumentFile(File $file = null)
    {
        $this->documentFile = $file;

        if (null !== $file) {
            // It is required that at least one field changes if you are using doctrine
            // otherwise the event listeners won't be called and the file is lost
            $this->createdAt = new \DateTimeImmutable();
        }

        return $this;
    }

    /**
     * Get the document type.
     *
     * @return mixed
     */
    public static function getdocument_type() {
        $c = get_called_class();

        return $c::DOCUMENT_TYPE;
    }

}
