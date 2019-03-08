<?php

declare(strict_types=1);

namespace App\Hydrator;

/**
 * Interface HydratorInterface
 */
interface HydratorInterface
{

    /**
     * Hydrate an objet.
     *
     * @param array $properties
     *
     * @return mixed
     */
    public function hydrate(array $properties);
}
