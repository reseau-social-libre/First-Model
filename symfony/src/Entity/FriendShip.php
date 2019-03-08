<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Timestampable\Traits\TimestampableEntity;

/**
 * @ORM\Entity(repositoryClass="App\Repository\FriendShipRepository")
 */
class FriendShip
{

    use TimestampableEntity;

    const TYPE_FRIEND = 'FRIEND';
    const TYPE_FOLLOW = 'FOLLOW';

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="friends")
     * @ORM\JoinColumn(nullable=false)
     */
    private $friend;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="friendsWithMe")
     * @ORM\JoinColumn(nullable=false)
     */
    private $friendWithMe;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $friendShipType;

    /**
     * @ORM\Column(type="boolean")
     */
    private $accepted = false;

    /**
     * FriendShip constructor.
     *
     * @param string|null $friendShipType
     */
    public function __construct(string $friendShipType = '')
    {
        if (!empty($friendShipType)) {
            $this->friendShipType = $friendShipType;
        } else {
            $this->friendShipType = self::TYPE_FRIEND;
        }

        if ($this->friendShipType == self::TYPE_FOLLOW) {
            $this->accepted = true;
        }
    }


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFriend(): ?User
    {
        return $this->friend;
    }

    public function setFriend(?User $friend): self
    {
        $this->friend = $friend;

        return $this;
    }

    public function getFriendWithMe(): ?User
    {
        return $this->friendWithMe;
    }

    public function setFriendWithMe(?User $friendWithMe): self
    {
        $this->friendWithMe = $friendWithMe;

        return $this;
    }

    public function getFriendShipType(): ?string
    {
        return $this->friendShipType;
    }

    public function setFriendShipType(string $friendShipType): self
    {
        $this->friendShipType = $friendShipType;

        return $this;
    }

    public function isAccepted(): ?bool
    {
        return $this->accepted;
    }

    public function setAccept(bool $value): self
    {
        $this->accepted = $value;

        return $this;
    }
}
