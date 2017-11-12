<?php
namespace Propaganda\Infrastructure\Repository;

use Doctrine\ORM\EntityManager;
use Propaganda\Domain\Entity\Article;
use Propaganda\Domain\Repository\ArticleRepositoryInterface;

class DoctrineArticleRepository implements ArticleRepositoryInterface
{
    private $entityManager;

    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function save(Article $article): void
    {
        $this->entityManager->persist($article);
        $this->entityManager->flush();
    }
}