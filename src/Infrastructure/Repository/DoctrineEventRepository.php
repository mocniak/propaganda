<?php

namespace Propaganda\Infrastructure\Repository;

use Doctrine\ORM\EntityManager;
use Propaganda\Domain\Entity\Article;
use Propaganda\Domain\Entity\Event;
use Propaganda\Domain\Repository\ArticleRepositoryInterface;
use Propaganda\Domain\Repository\EventRepositoryInterface;
use Ramsey\Uuid\UuidInterface;

class DoctrineEventRepository implements EventRepositoryInterface
{
    private $entityManager;
    private $repository;

    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->repository = $this->entityManager->getRepository(Event::class);
    }

    public function save(Event $event): void
    {
        $this->entityManager->persist($event);
        $this->entityManager->flush();
    }

    public function get(UuidInterface $id): Event
    {
        /** @var Event $event */
        $event = $this->repository->find($id);
        if (null === $event) throw new \Exception("Event not found for id " . $id->toString());
        return $event;
    }

    public function getUpcoming(int $int): array
    {
        return $this->repository->findBy([],['date' => 'ASC'], $int);
    }
}