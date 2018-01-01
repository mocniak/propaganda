<?php

namespace Propaganda\Domain;

use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Propaganda\Domain\Entity\Article;
use Propaganda\Domain\Entity\FeaturedArticles;
use Propaganda\Domain\Repository\ArticleRepositoryInterface;
use Propaganda\Domain\Repository\FeaturedArticlesRepositoryInterface;

class FeaturedArticleServiceTest extends TestCase
{
    /** @var FeaturedArticlesService */
    private $service;
    /** @var ArticleRepositoryInterface|MockObject */
    private $articleRepository;
    /** @var FeaturedArticlesRepositoryInterface|MockObject */
    private $featuredArticleRepository;

    public function setUp()
    {
        $this->articleRepository = $this->getMockBuilder(ArticleRepositoryInterface::class)
            ->getMock();
        $this->featuredArticleRepository = $this->getMockBuilder(FeaturedArticlesRepositoryInterface::class)
            ->getMock();
        $this->service = new FeaturedArticlesService($this->articleRepository, $this->featuredArticleRepository);
    }

    public function testWhenNoArticlesAreConfiguredServiceReturnsJustNewestArticles()
    {
        $article1 = new Article('some title', []);
        $article2 = new Article('some title', []);
        $newestArticles = [$article1, $article2];
        $featuredArticles = new FeaturedArticles(1, []);
        $this->articleRepository->expects($this->once())
            ->method('getNewest')
            ->willReturn($newestArticles);
        $this->featuredArticleRepository->expects($this->once())
            ->method('load')
            ->willReturn($featuredArticles);
        $this->assertEquals($this->service->getFeatured(), $newestArticles);
    }

    public function testWhenServiceReturnsNewestArticles()
    {
        $featuredArticle = new Article('some title', []);
        $article1 = new Article('some title', []);
        $article2 = new Article('some title', []);
        $newestArticles = [$article1, $featuredArticle, $article2];
        $featuredArticles = new FeaturedArticles(1, [$featuredArticle->getId()]);
        $this->articleRepository->expects($this->once())
            ->method('getNewest')
            ->willReturn($newestArticles);


        $this->assertSame($featuredArticle,$this->service->getFeatured([0]));
    }
}
