<?php

namespace Propaganda\Domain;

use Propaganda\Domain\Dto\EditFeaturedArticlesRequest;
use Propaganda\Domain\Entity\Article;
use Propaganda\Domain\Entity\FeaturedArticles;
use Propaganda\Domain\Exception\ArticleNotFoundException;
use Propaganda\Domain\Repository\ArticleRepositoryInterface;
use Propaganda\Domain\Repository\FeaturedArticlesRepositoryInterface;
use Ramsey\Uuid\UuidInterface;

class FeaturedArticlesService
{
    /**
     * @var ArticleRepositoryInterface
     */
    private $articleRepository;
    /**
     * @var FeaturedArticlesRepositoryInterface
     */
    private $featuredArticlesRepository;

    public function __construct(ArticleRepositoryInterface $articleRepository, FeaturedArticlesRepositoryInterface $featuredArticlesRepository)
    {
        $this->articleRepository = $articleRepository;
        $this->featuredArticlesRepository = $featuredArticlesRepository;
    }

    public function getFeatured(): array
    {
        $featuredArticlesIds = $this->getFeaturedArticlesIds();
        $featuredArticles = [];

        /** @var UuidInterface $featuredArticleId */
        foreach ($featuredArticlesIds->getAll() as $featuredArticleId) {
            try {
                $featuredArticles[] = $this->articleRepository->get($featuredArticleId);
            } catch (ArticleNotFoundException $exception) {
                continue;
            }
        }
        return $featuredArticles;
    }

    /**
     * @param int $amount
     * @return Article[]
     */
    public function getNotFeatured(int $amount): array
    {
        $featuredArticlesIds = $this->getFeaturedArticlesIds();
        $newestArticles = $this->articleRepository->getNewest($amount + $featuredArticlesIds->getAmount());
        /** @var Article $article */
        $newestArticles = array_filter($newestArticles, function ($article) use ($featuredArticlesIds) {
            return !in_array($article->getId(), $featuredArticlesIds->getAll());
        });
        return array_splice($newestArticles, 0, $amount);
    }

    public function getFeaturedArticlesIds(): FeaturedArticles
    {
        $featuredArticlesIds = $this->featuredArticlesRepository->get();
        if (null === $featuredArticlesIds) {
            return new FeaturedArticles(3, []);
        }
        return $featuredArticlesIds;
    }

    public function editFeaturedArticles(EditFeaturedArticlesRequest $request)
    {
        $featuredArticles = array_filter($request->arrayOfArticleIds,
            function ($id) {
                return $id !== null;
            }
        );
        $featuredArticlesIds = new FeaturedArticles(3, $featuredArticles);
        $this->featuredArticlesRepository->save($featuredArticlesIds);
    }
}