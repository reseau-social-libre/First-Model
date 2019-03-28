<?php

namespace App\Traits;

use Gedmo\Mapping\Annotation as Gedmo;
use Doctrine\ORM\Mapping as ORM;

/**
 * Trait SluggableTrait
 */
trait SluggableTrait
{

    /**
     * @ORM\Column(type="string", length=255)
     */
    protected $title;

    /**
     * @Gedmo\Slug(fields={"title"})
     * @ORM\Column(length=255, unique=true)
     *
     * @var string
     */
    protected $slug;

    /**
     * Get the entity title;
     *
     * @return null|string
     */
    public function getTitle(): ?string
    {
        return $this->title;
    }

    /**
     * Set the entity title.
     *
     * @param string $title
     *
     * @return self
     */
    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get the entity slug.
     *
     * @return string
     */
    public function getSlug()
    {
        return $this->slug;
    }

}
