<?php
namespace Propaganda\Domain\Repository;

use Propaganda\Domain\Entity\Article;

interface ArticleRepositoryInterface
{
    public function save(Article $article): void;
}