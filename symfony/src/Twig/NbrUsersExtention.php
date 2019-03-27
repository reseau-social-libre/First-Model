<?php

declare(strict_types=1);

namespace App\Twig;

use App\Manager\UserManager;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

/**
 * Class NbrUsersExtention
 */
class NbrUsersExtention extends AbstractExtension
{

    /**
     * @var UserManager
     */
    protected $userManager;

    /**
     * NbrUsersExtention constructor.
     *
     * @param UserManager $userManager
     */
    public function __construct(UserManager $userManager)
    {
        $this->userManager = $userManager;
    }

    /**
     * {@inheritdoc}
     */
    public function getFunctions(): array
    {
        return [
            new TwigFunction('nbrUsers', [$this, 'nbrUsers']),
        ];
    }

    /**
     * Get the total number of active user.
     *
     * @return mixed
     */
    public function nbrUsers()
    {
        return $this->userManager->getTotalActiveUser();
    }
}
