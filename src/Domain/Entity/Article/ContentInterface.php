<?php

namespace Propaganda\Domain\Entity\Article;

interface ContentInterface
{
    public function getType(): string;

    public function getValue(): string;
}