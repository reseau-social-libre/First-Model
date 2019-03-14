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

    /**
     * @var string
     *
     * @ORM\Column(name="stream", type="string", length=100)
     */
    protected $stream;

    /**
     * @return string|null
     */
    public function getStream(): ?string
    {
        return $this->stream;
    }

    /**
     * @param string $stream
     */
    public function setStream(string $stream)
    {
        $this->stream = $stream;
    }
}
