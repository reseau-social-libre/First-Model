<?php

declare(strict_types=1);

namespace App\Manager;

use App\Entity\FriendShip;
use App\Entity\User;
use App\Entity\UserRelationShip;
use App\Service\FriendShipService;

/**
 * Class FriendShipManager
 */
class FriendShipManager
{

    /**
     * @var FriendShipService
     */
    protected $friendShipService;

    /**
     * RelationshipManager constructor.
     *
     * @param FriendShipService $friendShipService
     */
    public function __construct(FriendShipService $friendShipService)
    {
        $this->friendShipService = $friendShipService;
    }

    /**
     * Add a friendShip.
     *
     * @param User   $fromUser
     * @param User   $toUser
     * @param string $friendShipType
     */
    public function addFriendShip(User $fromUser, User $toUser, string $friendShipType)
    {
        $this->friendShipService->addFriendShip($fromUser, $toUser, $friendShipType);
    }

    /**
     * Get a friendShip.
     *
     * @param User      $fromUser
     *  The user who make the friendShip request
     * @param User      $toUser
     *  The user who has received the friendShip request
     * @param string    $friendShipType
     * @param bool|null $accepted
     *
     * @return FriendShip
     */
    public function getFriendShip(User $fromUser, User $toUser, string $friendShipType, ?bool $accepted): FriendShip
    {
        return $this->friendShipService->findFriendShip($fromUser, $toUser, $friendShipType, $accepted);
    }

    /**
     * Accept a friendShip.
     *
     * @param User $user
     *  The user who make the friendShip request
     * @param User $toUser
     *  The user who accept friendShip
     */
    public function acceptFriendShip(User $user, User $toUser)
    {
        $this->friendShipService->acceptFriendShip($user, $toUser);
    }

    /**
     * Get all friend for a user.
     *
     * @param User     $user
     * @param int|null $limit
     *
     * @return User[]
     */
    public function getAllFriends(User $user, int $limit = null): array
    {
        return $this->friendShipService->getAllFriends($user, $limit);
    }

    /**
     * @param \App\Entity\User $user
     *
     * @return FriendShip[]
     */
    public function getPendingFriendRequest(User $user): array
    {
        return $this->friendShipService->getPendingFriendRequest($user);
    }

    /**
     * Check if users are friend.
     *
     * @param User $user
     * @param User $friend
     *
     * @return bool
     */
    public function isUserMyFriend(User $user, User $friend): bool
    {
        return $this->friendShipService->checkIsFriend($user, $friend);
    }

    /**
     * Get all followers for a user.
     *
     * @param User     $user
     * @param int|null $limit
     *
     * @return User[]
     */
    public function getAllFollowers(User $user, int $limit = null): array
    {
        return $this->friendShipService->findFollowers($user, $limit);
    }

    /**
     * Get the users followed by a user.
     *
     * @param User     $user
     * @param int|null $limit
     *
     * @return User[]
     */
    public function getAllFollowing(User $user, int $limit = null): array
    {
        return $this->friendShipService->findFollowing($user, $limit);
    }

    public function hasFriendPendingRequest(User $user, User $friendWithMe)
    {
        return $this->friendShipService->hasFriendPendingRequest($user, $friendWithMe);
    }

    public function isFollowed(User $user, User $friendWithMe)
    {
        return $this->friendShipService->checkIfFollowed($user, $friendWithMe);
    }

    /**
     * Set the userRelationShip.
     *
     * @param UserRelationShip $userRelationShip
     * @param int|null         $limit
     *
     * @return UserRelationShip
     */
    public function setUserRelationShip(UserRelationShip $userRelationShip, int $limit = null): UserRelationShip
    {
        $user = $userRelationShip->getUser();

        $userRelationShip->setFriends($this->getAllFriends($user, $limit))
            ->setFollowers($this->getAllFollowers($user, $limit))
            ->setFollowing($this->getAllFollowing($user, $limit))
            ->setFriendRequest($this->getPendingFriendRequest($user));

        return $userRelationShip;
    }
}
