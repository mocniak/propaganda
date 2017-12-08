<?php

namespace Propaganda\Domain\Dto;

use Propaganda\Domain\Entity\Article;
use Ramsey\Uuid\UuidInterface;

class EditArticleRequest
{
    public $articleId;
    public $title;
    public $content;
    public $coverImageId;

    public function __construct(UuidInterface $articleId, string $title, array $content, ?UuidInterface $coverImageId)
    {
        $this->articleId = $articleId;
        $this->title = $title;
        $this->content = $content;
        $this->coverImageId = $coverImageId;
    }

    public static function fromArticle(Article $article): self
    {
        $request = new static($article->getId(), $article->getTitle(), $article->getContent(), $article->getCoverImageId());
        return $request;
    }

}