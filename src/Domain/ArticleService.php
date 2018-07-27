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

    public function addArticle(NewArticleRequest $newArticleRequest): NewArticleResponse
    {
        $article = new Article($newArticleRequest->title, [], $newArticleRequest->author);
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
        $article->setCoverImageId($editArticleRequest->coverImageId);
        $article->setSlug($editArticleRequest->slug);
        $article->setAuthor($editArticleRequest->author);
        $this->articleRepository->save($article);

        return new EditArticleResponse(true, $article->getId());
    }

    public function getRecent($limit): array
    {
        $articles = $this->articleRepository->getNewestPublished($limit);

        return $articles;
    }

    public function getArticleBySlug(string $slug): Article
    {
        return $this->articleRepository->getBySlug($slug);
    }

    public function publishArticle(UuidInterface $articleId)
    {
        $article = $this->articleRepository->get($articleId);
        $article->publish();
        $this->articleRepository->save($article);
    }

    public function withdrawArticle(UuidInterface $articleId)
    {
        $article = $this->articleRepository->get($articleId);
        $article->withdraw();
        $this->articleRepository->save($article);
    }
}
