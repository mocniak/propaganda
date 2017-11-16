<?php
namespace Propaganda\Domain\Dto;

use Propaganda\Domain\Entity\Article;

class EditArticleRequest
{
    public $articleId;
    public $title;
    public $content;

    public static function fromArticle(Article $article): self
    {
        $request = new static();
        $request->articleId = $article->getId();
        $request->content = $article->getContent();
        $request->title = $article->getTitle();
        return $request;
    }

}