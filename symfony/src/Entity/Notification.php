<?php

declare(strict_types=1);

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\NotificationRepository")
 */
class Notification
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $content;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $link;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="notifications")
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;

    /**
     * @ORM\Column(type="boolean")
     */
    private $read = false;

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
     * Get the content.
     *
     * @return null|string
     */
    public function getContent(): ?string
    {
        return $this->content;
    }

    /**
     * Set the content.
     *
     * @param string $content
     *
     * @return Notification
     */
    public function setContent(string $content): self
    {
        $this->content = $content;

        return $this;
    }

    /**
     * Get the link.
     *
     * @return null|string
     */
    public function getLink(): ?string
    {
        return $this->link;
    }

    /**
     * Set the link.
     *
     * @param string $link
     *
     * @return Notification
     */
    public function setLink(string $link): self
    {
        $this->link = $link;

        return $this;
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
     * @return Notification
     */
    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    /**
     * @return mixed
     */
    public function isRead()
    {
        return $this->read;
    }

    /**
     * @param mixed $read
     */
    public function setRead($read)
    {
        $this->read = $read;
    }
}
