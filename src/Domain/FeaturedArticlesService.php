<?php
namespace Propaganda\Domain;

use Propaganda\Domain\Entity\Article;
use Propaganda\Domain\Entity\FeaturedArticles;
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
            $featuredArticles[] = $this->articleRepository->get($featuredArticleId);
        }
        return $featuredArticles;
    }

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

//    public function updateFeaturedArticlesIds(UpdateFeaturedArticlesRequest $request)
//    {
//        $featuredArticlesIds = new FeaturedArticles(5,$request->featuredArticlesIds);
//        $this->featuredArticlesRepository->save($featuredArticlesIds);
//    }

    public function getFeaturedArticlesIds(): FeaturedArticles
    {
        $featuredArticlesIds = $this->featuredArticlesRepository->get();
        if (null === $featuredArticlesIds) {
            return new FeaturedArticles(5, []);
        }
        return $featuredArticlesIds;
    }
}