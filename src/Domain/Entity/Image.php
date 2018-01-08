<?php

namespace Propaganda\Domain\Entity;

use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

class Image
{
    private $id;
    private $description;
    private $createdAt;

    public function __construct(string $description)
    {
        $this->id = Uuid::uuid4();
        $this->createdAt = new \DateTimeImmutable();
        $this->description = $description;
    }

    public function getId(): UuidInterface
    {
        return $this->id;
    }

    public function getCreatedAt(): \DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function getDescription(): string
    {
        return $this->description;
    }
}
