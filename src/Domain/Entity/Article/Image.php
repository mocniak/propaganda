<?php

namespace Propaganda\Domain\Entity\Article;

use Ramsey\Uuid\UuidInterface;

class Image implements ContentInterface
{
    private $fileId;

    public function __construct(UuidInterface $fileId)
    {
        $this->fileId = $fileId;
    }

    public function getType(): string
    {
        return 'image';
    }
}