<?php

namespace Propaganda\Infrastructure\Repository;

use Doctrine\ORM\EntityManager;
use Propaganda\Domain\Entity\Image;
use Propaganda\Domain\Repository\ImageRepositoryInterface;
use Ramsey\Uuid\UuidInterface;

class DoctrineImageRepository implements ImageRepositoryInterface
{
    private $entityManager;
    private $repository;

    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->repository = $this->entityManager->getRepository(Image::class);
    }

    public function save(Image $image): void
    {
        $this->entityManager->persist($image);
        $this->entityManager->flush();
    }

    public function get(UuidInterface $id): Image
    {
        /** @var Image $image */
        $image = $this->repository->find($id);
        if (null === $image) throw new \Exception("Image not found for id " . $id->toString());
        return $image;
    }

    public function getNewest($int): array
    {
        return $this->repository->findBy([], ['createdAt' => 'DESC'], $int);
    }
}