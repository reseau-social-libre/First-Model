<?php

declare(strict_types=1);

namespace App\Repository;

/**
 * Interface RepositoryInterface
 */
interface RepositoryInterface
{

    /**
     * Get the entityClass.
     *
     * @return string
     */
    public function getClass() : string;

}
