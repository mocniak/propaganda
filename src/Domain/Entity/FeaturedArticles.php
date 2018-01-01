<?php

namespace Propaganda\Domain\Entity;

use Ramsey\Uuid\UuidInterface;

class FeaturedArticles
{
    /** @var int */
    private $amount;
    /** @var array */
    private $featuredArticles;

    public function __construct(int $amount, array $featuredArticles)
    {
        $this->amount = $amount;
        foreach ($featuredArticles as $featuredArticleId)
        {
            if (!$featuredArticleId instanceof UuidInterface) {
                throw new \RuntimeException('Invalid Id type.');
            }
        }
        $this->featuredArticles = $featuredArticles;
    }

    public function getAll(): array
    {
        return $this->featuredArticles;
    }

    public function setAll(array $featured) {
        $this->featuredArticles = $featured;
    }

    public function getAmount(): int
    {
        return $this->amount;
    }
}