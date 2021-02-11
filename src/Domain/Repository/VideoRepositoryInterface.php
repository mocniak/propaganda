<?php

namespace Propaganda\Domain\Repository;

use Propaganda\Domain\Entity\Video;
use Ramsey\Uuid\UuidInterface;

interface VideoRepositoryInterface
{
    public function save(Video $video): void;

    public function get(UuidInterface $id): Video;

    public function getNewest($int): array;

    public function delete(UuidInterface $videoId): void;
}