<?php
namespace Propaganda\Domain\Repository;

use Propaganda\Domain\Entity\FeaturedArticles;

interface FeaturedArticlesRepositoryInterface
{
    public function save(FeaturedArticles $articles): void;

    public function get(): ?FeaturedArticles;
}