<?php

namespace Propaganda\Infrastructure\Repository;

use Doctrine\ORM\EntityManager;
use Propaganda\Domain\Entity\Video;
use Propaganda\Domain\Repository\VideoRepositoryInterface;
use Ramsey\Uuid\UuidInterface;

class DoctrineVideoRepository implements VideoRepositoryInterface
{
    private $entityManager;
    private $repository;

    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->repository = $this->entityManager->getRepository(Video::class);
    }

    public function save(Video $video): void
    {
        $this->entityManager->persist($video);
        $this->entityManager->flush();
    }

    public function get(UuidInterface $id): Video
    {
        /** @var Video $video */
        $video = $this->repository->find($id);
        if (null === $video) throw new \Exception("Image not found for id " . $id->toString());
        return $video;
    }

    public function getNewest($int): array
    {
        return $this->repository->findBy([], ['createdAt' => 'DESC'], $int);
    }

    public function delete(UuidInterface $videoId): void
    {
        $videoToDelete = $this->repository->find($videoId);
        $this->entityManager->remove($videoToDelete);
        $this->entityManager->flush();
    }
}