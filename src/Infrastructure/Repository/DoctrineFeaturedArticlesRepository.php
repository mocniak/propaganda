<?php

namespace Propaganda\Infrastructure\Repository;

use Doctrine\ORM\EntityManager;
use Propaganda\Domain\Entity\FeaturedArticles;
use Propaganda\Domain\Repository\FeaturedArticlesRepositoryInterface;

class DoctrineFeaturedArticlesRepository implements FeaturedArticlesRepositoryInterface
{
    private $entityManager;
    private $repository;

    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->repository = $this->entityManager->getRepository(FeaturedArticles::class);
    }

    public function save(FeaturedArticles $articles): void
    {
        $this->entityManager->persist($articles);
        $this->entityManager->flush();
    }

    public function get(): FeaturedArticles
    {
        // TODO: Implement get() method.
    }
}