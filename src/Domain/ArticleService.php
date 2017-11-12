<?php

namespace Propaganda\Domain;

use Propaganda\Domain\Dto\NewArticleDto;
use Propaganda\Domain\Entity\Article;
use Propaganda\Domain\Repository\ArticleRepositoryInterface;

class ArticleService
{
    /**
     * @var ArticleRepositoryInterface
     */
    private $articleRepository;

    public function __construct(ArticleRepositoryInterface $articleRepository)
    {
        $this->articleRepository = $articleRepository;
    }

    public function addArticle(NewArticleDto $dto): void
    {
        $article = new Article($dto->title, $dto->content);
        $this->articleRepository->save($article);
    }
}