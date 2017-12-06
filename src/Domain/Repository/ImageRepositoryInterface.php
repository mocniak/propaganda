<?php

namespace Propaganda\Domain\Repository;

use Propaganda\Domain\Entity\Image;
use Ramsey\Uuid\UuidInterface;

interface ImageRepositoryInterface
{
    public function save(Image $article): void;

    public function get(UuidInterface $id): Image;
}