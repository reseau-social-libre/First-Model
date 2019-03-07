<?php

declare(strict_types=1);

namespace App\Service;

use App\Entity\Relationship;
use App\Repository\RelationshipRepository;
use App\Repository\UserRepository;

/**
 * Class RelationshipService
 */
class RelationshipService
{

    /**
     * @var RelationshipRepository
     */
    protected $relationshipRepository;

    /**
     * @var UserRepository
     */
    protected $userRepository;

    /**
     * The relationship type.
     *
     * @var array
     */
    private $acceptedType = [
      Relationship::TYPE_FRIEND,
      Relationship::TYPE_FOLLOWERS,
    ];

    /**
     * RelationshipService constructor.
     *
     * @param RelationshipRepository $relationshipRepository
     * @param UserRepository         $userRepository
     */
    public function __construct(
        RelationshipRepository $relationshipRepository,
        UserRepository $userRepository
    ) {
        $this->relationshipRepository = $relationshipRepository;
        $this->userRepository = $userRepository;
    }

    /**
     * Add new relationship.
     *
     * @param $userFrom
     * @param $userTo
     * @param $type
     *
     * @throws \Exception
     */
    public function addNewRelationship($userFrom, $userTo, $type)
    {
        if (!$this->isTypeAccepted($type)) {
            throw new \Exception('Relationship type not implemented');
        }

        if ((null == $relationship = $this->relationshipRepository->findOneBy([
                'fromUser' => $userFrom,
                'toUser' => $userTo,
                'type' => $type,
            ])) && (null == $relationship = $this->relationshipRepository->findOneBy([
                'fromUser' => $userTo,
                'toUser' => $userFrom,
                'type' => $type,
            ]))
        ) {
            $relationship = new Relationship();
            $relationship->setFromUser($userFrom)
                ->setToUser($userTo)
                ->setType($type);

            if (Relationship::TYPE_FOLLOWERS == $type) {
                $relationship->setAccepted(true);
            }

            $this->relationshipRepository->persistAndFlush($relationship);
        }
    }

    /**
     * Remove a relationship by id.
     *
     * @param int $id
     */
    public function removeRelationshipById(int $id)
    {
        if (null !== $relationship = $this->relationshipRepository->find($id)) {
            $this->relationshipRepository->removeAndFlush($relationship);
        }
    }

    /**
     * Remove a relationship by users and type.
     *
     * @param int    $userFrom
     * @param int    $userTo
     * @param string $type
     */
    public function removeRelationshipByUsersAndType(int $userFrom, int $userTo, string $type)
    {
        if ((null !== $relationship = $this->relationshipRepository->findOneBy([
                'fromUser' => $userFrom,
                'toUser' => $userTo,
                'type' => $type,
            ])) || (null !== $relationship = $this->relationshipRepository->findOneBy([
                'fromUser' => $userTo,
                'toUser' => $userFrom,
                'type' => $type,
            ]))
        ) {
            $this->relationshipRepository->removeAndFlush($relationship);
        }
    }

    /**
     * Accept a relationship.
     *
     * @param int $id
     */
    public function acceptRelationship(int $id) {
        if (null !== $relationship = $this->relationshipRepository->find($id)) {
            $relationship->setAccepted(true);

            $this->relationshipRepository->persistAndFlush($relationship);
        }
    }

    /**
     * Check if type is implemented.
     *
     * @param string $type
     *
     * @return bool
     */
    private function isTypeAccepted(string $type): bool
    {
        if (!in_array($type, $this->acceptedType)) {
            return false;
        }

        return true;
    }

    /**
     * Get number of followers for a user.
     *
     * @param int $user
     *
     * @return Relationship[]
     */
    public function getFollowersCount(int $user)
    {
        return $this->relationshipRepository->findBy([
           'toUser' => $user,
           'type' => Relationship::TYPE_FOLLOWERS,
        ]);
    }

    /**
     * Get the number of following users.
     *
     * @param $user
     *
     * @return Relationship[]
     */
    public function getFollowingCount($user)
    {
        return $this->relationshipRepository->findBy([
            'fromUser' => $user,
            'type' => Relationship::TYPE_FOLLOWERS,
        ]);
    }

    /**
     * Get friends for a user.
     *
     * @param int $user
     *
     * @return mixed
     */
    public function getFriends(int $user)
    {
        $friendIdsFrom = $this->relationshipRepository->findFriendsFrom($user);
        $friendIdsTo = $this->relationshipRepository->findFriendsTo($user);

        return $this->userRepository->findUsersFromIds(array_merge($friendIdsFrom, $friendIdsTo));
    }

}
