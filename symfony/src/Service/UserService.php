<?php

declare(strict_types=1);

namespace App\Service;

use App\Entity\User;
use App\Repository\UserRepository;

/**
 * Class UserService
 */
class UserService
{

    /**
     * @var UserRepository
     */
    protected $userRepository;

    /**
     * UserService constructor.
     *
     * @param UserRepository $userRepository
     */
    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * Get one user by criteria.
     *
     * @param array $criteria
     *
     * @return User|null
     */
    public function getUserBy(array $criteria)
    {
        return $this->userRepository->findOneBy($criteria);
    }

}
