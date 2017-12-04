<?php

namespace Propaganda\Domain\Entity\Article;

class Text implements ContentInterface
{
    private $content;

    public function __construct(string $content)
    {
        $this->content = $content;
    }

    public function getValue(): string
    {
        return $this->content;
    }

    public function getType(): string
    {
        return 'text';
    }
}