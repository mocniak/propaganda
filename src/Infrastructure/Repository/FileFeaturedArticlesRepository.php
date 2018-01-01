<?php

namespace Propaganda\Infrastructure\Repository;

use Propaganda\Domain\Entity\FeaturedArticles;
use Propaganda\Domain\Repository\FeaturedArticlesRepositoryInterface;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

class FileFeaturedArticlesRepository implements FeaturedArticlesRepositoryInterface
{
    private $featuredArticlesFolderPath;

    public function __construct(string $featuredArticlesFolderPath)
    {
        $this->featuredArticlesFolderPath = $featuredArticlesFolderPath;
    }

    public function save(FeaturedArticles $articles): void
    {
        if (!is_dir($this->featuredArticlesFolderPath)) {
            mkdir($this->featuredArticlesFolderPath . '/', 0777, true);
        }
        $stringIds = [];

        /** @var UuidInterface $id */
        foreach ($articles->getAll() as $id) {
            $stringIds[] = $id->toString();
        };
        $idArray = implode(',', $stringIds);
        file_put_contents($this->featuredArticlesFolderPath . '/featuredArticles.txt', $idArray);
    }

    public function get(): ?FeaturedArticles
    {
        if (!file_exists($this->featuredArticlesFolderPath . '/featuredArticles.txt')) {
            return null;
        }
        $stringIds = explode(',', file_get_contents($this->featuredArticlesFolderPath . '/featuredArticles.txt'));
        $idArray = [];
        foreach ($stringIds as $stringId) {
            $idArray[] = Uuid::fromString($stringId);
        }

        return new FeaturedArticles(5, $idArray);
    }
}