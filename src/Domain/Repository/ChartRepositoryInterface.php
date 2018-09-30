<?php

namespace Propaganda\Domain\Repository;

use Propaganda\Domain\Entity\Chart;
use Ramsey\Uuid\UuidInterface;

interface ChartRepositoryInterface
{
    public function save(Chart $video): void;

    public function get(UuidInterface $id): Chart;

    public function getNewest($int): array;
}