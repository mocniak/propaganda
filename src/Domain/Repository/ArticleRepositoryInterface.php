<?php

namespace Propaganda\Domain\Repository;

use Propaganda\Domain\Entity\Article;
use Ramsey\Uuid\UuidInterface;

interface ArticleRepositoryInterface
{
    public function save(Article $article): void;

    public function get(UuidInterface $id): Article;

    public function getNewestPublished(int $int): array;

    public function getNewest(int $int): array;

    public function getBySlug($slug): Article;
}