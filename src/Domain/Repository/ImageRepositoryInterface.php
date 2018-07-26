<?php

namespace Propaganda\Domain\Repository;

use Propaganda\Domain\Entity\Image;
use Ramsey\Uuid\UuidInterface;

interface ImageRepositoryInterface
{
    public function save(Image $image): void;

    public function get(UuidInterface $id): Image;

    public function getNewest($int): array;
}