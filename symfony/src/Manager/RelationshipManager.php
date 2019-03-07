<?php

declare(strict_types=1);

namespace App\Manager;

use App\Service\RelationshipService;

/**
 * Class RelationshipManager
 */
class RelationshipManager
{

    /**
     * @var RelationshipService
     */
    protected $relationshipService;

    /**
     * RelationshipManager constructor.
     *
     * @param RelationshipService $relationshipService
     */
    public function __construct(RelationshipService $relationshipService)
    {
        $this->relationshipService = $relationshipService;
    }

    /**
     * Add a new relationship.
     *
     * @param int    $userFrom
     * @param int    $userTo
     * @param string $type
     */
    public function addRelationShip(int $userFrom, int $userTo, string $type)
    {
        $this->relationshipService->addNewRelationship($userFrom, $userTo, $type);
    }

    /**
     * Accept a relationship
     *
     * @param int $id
     */
    public function acceptRelationship(int $id)
    {
        $this->relationshipService->acceptRelationship($id);
    }

    /**
     * Remove a relationship.
     *
     * @param int         $id
     * @param int|null    $from
     * @param int|null    $to
     * @param string|null $type
     */
    public function removeRelationship(int $id, int $from = null, int $to = null, string $type = null)
    {
        if (null !== $from && null !== $to && null !== $type) {
            $this->relationshipService->removeRelationshipByUsersAndType($from, $to, $type)
        } else {
            $this->relationshipService->removeRelationshipById($id);
        }
    }

}
