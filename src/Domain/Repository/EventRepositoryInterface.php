<?php
namespace Propaganda\Domain\Repository;

use Propaganda\Domain\Entity\Event;
use Ramsey\Uuid\UuidInterface;

interface EventRepositoryInterface
{
    public function save(Event $event): void;

    public function get(UuidInterface $id): Event;

    public function getUpcoming(int $int): array;
}