<?php

declare(strict_types=1);

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\Table;
use Doctrine\ORM\Mapping\UniqueConstraint;

/**
 * Class Relationship
 *
 * @Table(name="relationship",
 *    uniqueConstraints={
 *        @UniqueConstraint(name="relationship_unique",
 *            columns={"from_user", "to_user", "type"})
 *    }
 * )
 * @ORM\Entity(repositoryClass="App\Repository\RelationshipRepository")
 */
class Relationship
{

    const TYPE_FOLLOWERS = 'TYPE_FOLLOWERS';
    const TYPE_FRIEND = 'TYPE_FRIENDS';

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    protected $id;

    /**
     * @ORM\Column(type="integer")
     */
    protected $fromUser;

    /**
     * @ORM\Column(type="integer")
     */
    protected $toUser;

    /**
     * @ORM\Column(type="string", length=50)
     */
    protected $type;

    /**
     * @ORM\Column(type="boolean")
     */
    protected $accepted = false;

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
     * @return mixed
     */
    public function getFromUser()
    {
        return $this->fromUser;
    }

    /**
     * @param int $fromUser
     *
     * @return Relationship
     */
    public function setFromUser(int $fromUser): self
    {
        $this->fromUser = $fromUser;

        return $this;
    }

    /**
     * @return int
     */
    public function getToUser(): ?int
    {
        return $this->toUser;
    }

    /**
     * @param int $toUser
     *
     * @return Relationship
     */
    public function setToUser(int $toUser)
    {
        $this->toUser = $toUser;

        return $this;
    }

    /**
     * Get the relationship type.
     *
     * @return null|string
     */
    public function getType(): ?string
    {
        return $this->type;
    }

    /**
     * Set the relationship type.
     *
     * @param string $type
     *
     * @return Relationship
     */
    public function setType(string $type): self
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Is the relationship was accepted by the to user.
     *
     * @return bool|null
     */
    public function getAccepted(): ?bool
    {
        return $this->accepted;
    }

    /**
     * Accept the relationship.
     *
     * @param bool $accepted
     *
     * @return Relationship
     */
    public function setAccepted(bool $accepted): self
    {
        $this->accepted = $accepted;

        return $this;
    }

}
