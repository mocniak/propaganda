<?php

namespace Propaganda\Domain\Dto;

use Propaganda\Domain\Entity\Event;
use Ramsey\Uuid\UuidInterface;

class EditEventRequest
{
    /**
     * @var UuidInterface
     */
    public $eventId;
    /**
     * @var string
     */
    public $title;
    /**
     * @var string
     */
    public $description;
    /**
     * @var \DateTimeImmutable
     */
    public $date;

    public function __construct(UuidInterface $eventId, string $title, string $description, \DateTimeImmutable $date)
    {
        $this->eventId = $eventId;
        $this->title = $title;
        $this->description = $description;
        $this->date = $date;
    }

    public static function fromEvent(Event $event): self
    {
        $request = new static($event->getId(), $event->title, $event->description, $event->date);
        return $request;
    }

}