<?php

namespace Propaganda\Domain\Entity;

use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

class Event
{
    private $id;
    public $date;
    public $title;
    public $description;

    public function __construct(\DateTimeImmutable $date, string $title, string $description)
    {
        $this->id = Uuid::uuid4();
        $this->date = $date;
        $this->title = $title;
        $this->description = $description;
    }

    public function getId(): UuidInterface
    {
        return $this->id;
    }
}