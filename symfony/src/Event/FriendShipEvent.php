<?php

declare(strict_types=1);

namespace App\Event;

use App\Entity\User;
use Symfony\Component\EventDispatcher\Event;

/**
 * Class FriendRequestEvent
 */
class FriendShipEvent extends Event
{

    /**
     * @var User
     */
    protected $user;

    /**
     * @var User
     */
    protected $friend;

    /**
     * Get user.
     *
     * @return User
     */
    public function getUser(): User
    {
        return $this->user;
    }

    /**
     * Set user.
     *
     * @param User $user
     *
     * @return FriendShipEvent
     */
    public function setUser(User $user): FriendShipEvent
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get friend.
     *
     * @return User
     */
    public function getFriend(): User
    {
        return $this->friend;
    }

    /**
     * Set friend.
     *
     * @param User $friend
     *
     * @return FriendShipEvent
     */
    public function setFriend(User $friend): FriendShipEvent
    {
        $this->friend = $friend;

        return $this;
    }
}
