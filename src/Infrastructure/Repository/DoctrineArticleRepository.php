<?php

namespace Propaganda\Infrastructure\Repository;

use Doctrine\ORM\EntityManager;
use Propaganda\Domain\Entity\Article;
use Propaganda\Domain\Exception\ArticleNotFoundException;
use Propaganda\Domain\Repository\ArticleRepositoryInterface;
use Ramsey\Uuid\UuidInterface;

class DoctrineArticleRepository implements ArticleRepositoryInterface
{
    private $entityManager;
    private $repository;

    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->repository = $this->entityManager->getRepository(Article::class);
    }

    public function save(Article $article): void
    {
        $this->entityManager->persist($article);
        $this->entityManager->flush();
    }

    public function get(UuidInterface $id): Article
    {
        /** @var Article $article */
        $article = $this->repository->find($id);
        if (null === $article) throw new ArticleNotFoundException("Article not found for id " . $id->toString());
        return $article;
    }

    public function getNewest(int $int): array
    {
        return $this->repository->findBy([],['createdAt' => 'DESC'], $int);
    }

    public function getBySlug($slug): Article
    {
        return $this->repository->findOneBy(['slug'=>$slug]);
    }
}