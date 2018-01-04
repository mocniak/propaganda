<?php

namespace Propaganda\Domain;

use Propaganda\Domain\Dto\EditEventRequest;
use Propaganda\Domain\Dto\EditEventResponse;
use Propaganda\Domain\Dto\NewEventRequest;
use Propaganda\Domain\Dto\NewEventResponse;
use Propaganda\Domain\Entity\Event;
use Propaganda\Domain\Repository\EventRepositoryInterface;
use Ramsey\Uuid\UuidInterface;

class EventService
{
    /**
     * @var EventRepositoryInterface
     */
    private $eventRepository;

    public function __construct(EventRepositoryInterface $eventRepository)
    {
        $this->eventRepository = $eventRepository;
    }

    public function addEvent(NewEventRequest $request): NewEventResponse
    {
        $event = new Event(new \DateTimeImmutable(), $request->title, '');
        $this->eventRepository->save($event);
        return new NewEventResponse(true, $event->getId());
    }

    public function getEvent(UuidInterface $id): Event
    {
        return $this->eventRepository->get($id);
    }

    public function editEvent(EditEventRequest $editEventRequest): EditEventResponse
    {
        $event = $this->getEvent($editEventRequest->eventId);
        $event->title = $editEventRequest->title;
        $event->description = $editEventRequest->description;
        $event->date = $editEventRequest->date;
        $this->eventRepository->save($event);
        return new EditEventResponse(true);
    }

    public function getUpcoming(int $amount): array
    {
        return $this->eventRepository->getUpcoming($amount);
    }
}