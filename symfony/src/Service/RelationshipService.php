<?php

declare(strict_types=1);

namespace App\Service;

use App\Entity\Relationship;
use App\Repository\RelationshipRepository;

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
     */
    public function __construct(RelationshipRepository $relationshipRepository)
    {
        $this->relationshipRepository = $relationshipRepository;
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

        if (null == $relationship = $this->relationshipRepository->findOneBy([
                'user_from' => $userFrom,
                'user_to' => $userTo,
                'type' => $type,
            ])
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
        if (null !== $relationship = $this->relationshipRepository->findOneBy([
                'user_from' => $userFrom,
                'user_to' => $userTo,
                'type' => $type,
            ])
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

}
