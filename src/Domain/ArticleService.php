<?php

namespace Propaganda\Domain;

use Propaganda\Domain\Dto\EditArticleRequest;
use Propaganda\Domain\Dto\EditArticleResponse;
use Propaganda\Domain\Dto\NewArticleRequest;
use Propaganda\Domain\Dto\NewArticleResponse;
use Propaganda\Domain\Entity\Article;
use Propaganda\Domain\Repository\ArticleRepositoryInterface;
use Ramsey\Uuid\UuidInterface;

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

    public function addArticle(NewArticleRequest $dto): NewArticleResponse
    {
        $article = new Article($dto->title, $dto->content);
        $this->articleRepository->save($article);
        return new NewArticleResponse(true, $article->getId());
    }

    public function getArticle(UuidInterface $id): Article
    {
        return $this->articleRepository->get($id);
    }

    public function editArticle(EditArticleRequest $editArticleRequest): EditArticleResponse
    {
        $article = $this->getArticle($editArticleRequest->articleId);
        $article->setTitle($editArticleRequest->title);
        $article->setContent($editArticleRequest->content);
        $this->articleRepository->save($article);
        return new EditArticleResponse(true, $article->getId());
    }
}