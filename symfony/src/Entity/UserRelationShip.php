<?php

declare(strict_types=1);

namespace App\Entity;

/**
 * Class UserRelationShip
 */
class UserRelationShip
{

    /**
     * @var User
     */
    protected $user;

    /**
     * @var User[]
     */
    protected $friends;

    /**
     * @var User[]
     */
    protected $followers;

    /**
     * @var User[]
     */
    protected $following;

    /**
     * @var bool
     */
    protected $isFollowed = false;

    /**
     * @var bool
     */
    protected $isFriendPending = false;

    /**
     * @var bool
     */
    protected $isRequestMeFriend = false;

    /**
     * @var bool
     */
    protected $isFriend = false;

    /**
     * @var FriendShip[]
     */
    protected $friendRequest;

    /**
     * UserRelationShip constructor.
     *
     * @param User $user
     */
    public function __construct(User $user)
    {
        $this->user = $user;
    }

    /**
     * @return User
     */
    public function getUser(): User
    {
        return $this->user;
    }

    /**
     * @return User[]
     */
    public function getFriends(): array
    {
        return $this->friends;
    }

    /**
     * @param User[] $friends
     *
     * @return UserRelationShip
     */
    public function setFriends(array $friends): UserRelationShip
    {
        $this->friends = $friends;

        return $this;
    }

    /**
     * @return User[]
     */
    public function getFollowers(): array
    {
        return $this->followers;
    }

    /**
     * @param User[] $followers
     *
     * @return UserRelationShip
     */
    public function setFollowers(array $followers): UserRelationShip
    {
        $this->followers = $followers;

        return $this;
    }

    /**
     * @return User[]
     */
    public function getFollowing(): array
    {
        return $this->following;
    }

    /**
     * @param User[] $following
     *
     * @return UserRelationShip
     */
    public function setFollowing(array $following): UserRelationShip
    {
        $this->following = $following;

        return $this;
    }

    /**
     * @return FriendShip[]
     */
    public function getFriendRequest(): array
    {
        return $this->friendRequest;
    }

    /**
     * @param FriendShip[] $friendRequest
     *
     * @return UserRelationShip
     */
    public function setFriendRequest(array $friendRequest): UserRelationShip
    {
        $this->friendRequest = $friendRequest;

        return $this;
    }

    /**
     * @return bool
     */
    public function isFollowed(): bool
    {
        return $this->isFollowed;
    }

    /**
     * @param bool $isFollowed
     *
     * @return UserRelationShip
     */
    public function setIsFollowed(bool $isFollowed): UserRelationShip
    {
        $this->isFollowed = $isFollowed;

        return $this;
    }

    /**
     * @return bool
     */
    public function isFriendPending(): bool
    {
        return $this->isFriendPending;
    }

    /**
     * @param bool $isFriendPending
     *
     * @return UserRelationShip
     */
    public function setIsFriendPending(bool $isFriendPending): UserRelationShip
    {
        $this->isFriendPending = $isFriendPending;

        return $this;
    }

    /**
     * @return bool
     */
    public function isRequestMeFriend(): bool
    {
        return $this->isRequestMeFriend;
    }

    /**
     * @param bool $isRequestMeFriend
     *
     * @return UserRelationShip
     */
    public function setIsRequestMeFriend(bool $isRequestMeFriend): UserRelationShip
    {
        $this->isRequestMeFriend = $isRequestMeFriend;

        return $this;
    }

    /**
     * @return bool
     */
    public function isFriend(): bool
    {
        return $this->isFriend;
    }

    /**
     * @param bool $isFriend
     *
     * @return UserRelationShip
     */
    public function setIsFriend(bool $isFriend): UserRelationShip
    {
        $this->isFriend = $isFriend;

        return $this;
    }
}
