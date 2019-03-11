<?php

declare(strict_types=1);

namespace App\Service;

use App\Entity\FriendShip;
use App\Entity\User;
use App\Hydrator\HydratorInterface;
use App\Repository\FriendShipRepository;

/**
 * Class RelationshipService
 */
class FriendShipService
{

    /**
     * @var FriendShipRepository
     */
    protected $friendShipRepository;

    /**
     * @var HydratorInterface
     */
    protected $friendShipHydrator;

    /**
     * FriendShipService constructor.
     *
     * @param FriendShipRepository $friendShipRepository
     * @param HydratorInterface    $hydrator
     */
    public function __construct(FriendShipRepository $friendShipRepository, HydratorInterface $hydrator)
    {
        $this->friendShipRepository = $friendShipRepository;
        $this->friendShipHydrator = $hydrator;
    }

    /**
     * Find friendship.
     *
     * @param User      $fromUser
     * @param User      $toUser
     * @param string    $friendShipType
     * @param bool|null $accepted
     *
     * @return \App\Entity\FriendShip
     */
    public function findFriendShip(User $fromUser, User $toUser, string $friendShipType, ?bool $accepted)
    {
        $params = [
            'friend' => $fromUser,
            'friendWithMe' => $toUser,
            'friendShipType' => $friendShipType,
        ];

        if (null !== $accepted) {
            $params['accepted'] = $accepted;
        }

        return $this->friendShipRepository->findOneBy($params);
    }

    /**
     * Add a friendRelationShip.
     *
     * @param User   $fromUser
     * @param User   $toUser
     * @param string $friendShipType
     */
    public function addFriendShip(User $fromUser, User $toUser, string $friendShipType)
    {
        if (null === $friendShip = $this->findFriendShip($fromUser, $toUser, $friendShipType, null)) {
            // TODO: Use strategy instead statements.
            if (FriendShip::TYPE_FOLLOW === $friendShipType) {
                $friendShip = $this->friendShipHydrator->hydrate(
                    [
                        'friend' => $fromUser,
                        'friendWithMe' => $toUser,
                        'friendShipType' => FriendShip::TYPE_FOLLOW,
                        'accept' => true,
                    ]
                );

                $this->friendShipRepository->persistAndFlush($friendShip);
            }

            if (FriendShip::TYPE_FRIEND === $friendShipType) {
                $friendShip = $this->friendShipHydrator->hydrate(
                    [
                        'friend' => $fromUser,
                        'friendWithMe' => $toUser,
                        'friendShipType' => FriendShip::TYPE_FRIEND,
                    ]
                );

                $this->friendShipRepository->persistAndFlush($friendShip);
            }
        }
    }

    /**
     * Accept a friend request.
     *
     * @param User $fromUser
     *  The user who send the request.
     * @param User $toUser
     *  The user who accept the friend request.
     */
    public function acceptFriendShip(User $fromUser, User $toUser)
    {
        if (null !== $friendShip = $this->findFriendShip($fromUser, $toUser, FriendShip::TYPE_FRIEND, false)) {
            $friendShip->setAccept(true);

            $inverseFriendShip = $this->friendShipHydrator->hydrate(
                [
                    'friend' => $toUser,
                    'friendWithMe' => $fromUser,
                    'friendShipType' => FriendShip::TYPE_FRIEND,
                    'accept' => true,
                ]
            );

            $this->friendShipRepository->persistAndFlush($friendShip);
            $this->friendShipRepository->persistAndFlush($inverseFriendShip);
        }
    }

    /**
     * Get all friends.
     *
     * @param User     $user
     * @param int|null $limit
     *
     * @return User[]
     */
    public function getAllFriends(User $user, int $limit = null): array
    {
        $friends = $this->friendShipRepository->findAllFriends($user, $limit);

        return $friends;
    }

    /**
     * Remove a friendShip.
     *
     * @param FriendShip $friendShip
     */
    public function removeFriendShip(FriendShip $friendShip)
    {
        $this->friendShipRepository->removeAndFlush($friendShip);
    }

    /**
     * Get the pending friend request for a user.
     *
     * @param User $user
     *
     * @return FriendShip[]
     */
    public function getPendingFriendRequest(User $user): array
    {
        $friendRequest = $this->friendShipRepository->findPendingFriendRequest($user);

        return $friendRequest;
    }

    /**
     * Check if two users are friends.
     *
     * @param User $user
     * @param User $friend
     *
     * @return bool
     */
    public function checkIsFriend(User $user, User $friend): bool
    {
        $friendShip = $this->friendShipRepository->findOneBy(
            [
                'friend' => $friend,
                'friendWithMe' => $user,
                'friendShipType' => FriendShip::TYPE_FRIEND,
                'accepted' => true,
            ]
        );

        return null !== $friendShip;
    }

    public function checkIfFollowed($user, $friendWithMe)
    {
        $followed = $this->friendShipRepository->findOneBy(
            [
                'friend' => $user,
                'friendWithMe' => $friendWithMe,
                'friendShipType' => FriendShip::TYPE_FOLLOW,
            ]
        );

        return null !== $followed;
    }

    /**
     * Find the user's followers.
     *
     * @param User     $user
     * @param int|null $limit
     *
     * @return User[]
     */
    public function findFollowers(User $user, int $limit = null): array
    {
        return  $this->friendShipRepository->findFollowers($user, $limit);
    }

    /**
     * Find users who are followed by a user.
     *
     * @param User     $user
     * @param int|null $limit
     *
     * @return User[]
     */
    public function findFollowing(User $user, int $limit = null): array
    {
        return $this->friendShipRepository->findFollowing($user, $limit);
    }

    /**
     * @param $user
     * @param $friendWithMe
     *
     * @return bool
     */
    public function hasFriendPendingRequest($user, $friendWithMe): bool
    {
        $pending = $this->friendShipRepository->findOneBy(
            [
                'friend' => $user,
                'friendWithMe' => $friendWithMe,
                'friendShipType' => FriendShip::TYPE_FRIEND,
                'accepted' => false
            ]
        );

        return null !== $pending;
    }
}
