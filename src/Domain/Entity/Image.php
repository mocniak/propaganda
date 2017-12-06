<?php

namespace Propaganda\Domain\Entity;

use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

class Image
{
    private $id;
    private $description;

    public function __construct(string $description)
    {
        $this->id = Uuid::uuid4();
        $this->description = $description;
    }

    public function getId(): UuidInterface
    {
        return $this->id;
    }
}