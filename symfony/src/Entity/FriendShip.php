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

        if ($this->friendShipType === self::TYPE_FOLLOW) {
            $this->accepted = true;
        }
    }

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return User|null
     */
    public function getFriend(): ?User
    {
        return $this->friend;
    }

    /**
     * @param User|null $friend
     *
     * @return FriendShip
     */
    public function setFriend(?User $friend): self
    {
        $this->friend = $friend;

        return $this;
    }

    /**
     * @return User|null
     */
    public function getFriendWithMe(): ?User
    {
        return $this->friendWithMe;
    }

    /**
     * @param User|null $friendWithMe
     *
     * @return FriendShip
     */
    public function setFriendWithMe(?User $friendWithMe): self
    {
        $this->friendWithMe = $friendWithMe;

        return $this;
    }

    /**
     * @return null|string
     */
    public function getFriendShipType(): ?string
    {
        return $this->friendShipType;
    }

    /**
     * @param string $friendShipType
     *
     * @return FriendShip
     */
    public function setFriendShipType(string $friendShipType): self
    {
        $this->friendShipType = $friendShipType;

        return $this;
    }

    /**
     * @return bool|null
     */
    public function isAccepted(): ?bool
    {
        return $this->accepted;
    }

    /**
     * @param bool $value
     *
     * @return FriendShip
     */
    public function setAccept(bool $value): self
    {
        $this->accepted = $value;

        return $this;
    }
}
