<?php

namespace Propaganda\Domain\Dto;

class EditFeaturedArticlesRequest
{
    public $arrayOfArticleIds;

    public function __construct(array $featuredArticlesIds)
    {
        $this->arrayOfArticleIds = $featuredArticlesIds;
        while (count($this->arrayOfArticleIds) < 3) {
            $this->arrayOfArticleIds[] = null;
        }
    }
}
