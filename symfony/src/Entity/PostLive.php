<?php

declare(strict_types=1);

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class PostLive
 *
 * @ORM\Entity()
 */
class PostLive extends PostText
{

    const POST_TYPE = 'Live';
}
