<?php

declare(strict_types=1);

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class PostVideo
 *
 * @ORM\Entity()
 */
class PostVideo extends PostText
{

    const POST_TYPE = 'Video';

}
