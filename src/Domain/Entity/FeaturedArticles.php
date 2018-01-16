<?php

namespace Propaganda\Domain\Entity;

use Ramsey\Uuid\UuidInterface;

class FeaturedArticles
{
    /** @var int */
    private $amount;
    /** @var array */
    private $all;

    public function __construct(int $amount, array $featuredArticles)
    {
        $this->amount = $amount;
        foreach ($featuredArticles as $featuredArticleId) {
            if (!$featuredArticleId instanceof UuidInterface) {
                throw new \RuntimeException('Invalid Id type.');
            }
        }
        $this->all = $featuredArticles;
    }

    public function getAll(): array
    {
        return $this->all;
    }

    public function setAll(array $featured)
    {
        $this->all = $featured;
    }

    public function getAmount(): int
    {
        return $this->amount;
    }
}