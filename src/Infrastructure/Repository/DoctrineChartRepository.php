<?php

namespace Propaganda\Infrastructure\Repository;

use Doctrine\ORM\EntityManager;
use Propaganda\Domain\Entity\Chart;
use Propaganda\Domain\Repository\ChartRepositoryInterface;
use Ramsey\Uuid\UuidInterface;

class DoctrineChartRepository implements ChartRepositoryInterface
{
    private $entityManager;
    private $repository;

    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->repository = $this->entityManager->getRepository(Chart::class);
    }

    public function save(Chart $chart): void
    {
        $this->entityManager->clear(); //weird hack for persisting embedded collection ¯\_(ツ)_/¯
        $this->entityManager->merge($chart);
        $this->entityManager->flush();
    }

    public function get(UuidInterface $id): Chart
    {
        /** @var Chart $chart */
        $chart = $this->repository->find($id);
        if (null === $chart) throw new \Exception("Chart not found for id " . $id->toString());
        return $chart;
    }

    public function getNewest($int): array
    {
        return $this->repository->findBy([], ['createdAt' => 'DESC'], $int);
    }
}