<?php

namespace Propaganda\Domain;

use Propaganda\Domain\Dto\EditChartRequest;
use Propaganda\Domain\Entity\Chart;
use Propaganda\Domain\Entity\Chart\Column;
use Propaganda\Domain\Repository\ChartRepositoryInterface;
use Ramsey\Uuid\UuidInterface;

class ChartService
{
    /**
     * @var ChartRepositoryInterface
     */
    private $repository;

    public function __construct(ChartRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function getChart(UuidInterface $id): Chart
    {
        return $this->repository->get($id);
    }

    public function editChart(EditChartRequest $request): void
    {
        $chart = $this->repository->get($request->id);
        $chart->setName($request->name);
        $chart->setColumns($request->columns);
        $chart->setData($request->data);
        $this->repository->save($chart);
    }

    public function addEmptyChart(): UuidInterface
    {
        $chart = new Chart(
            'Nazwa wykresu',
            [
                new Column('Kolumna 1', Column::STRING_TYPE),
                new Column('Kolumna 2', Column::NUMBER_TYPE)
            ],
            [
                ['Pierwszy wiersz', 12],
                ['Drugi wiersz', 10]
            ]
        );
        $this->repository->save($chart);

        return $chart->getId();
    }
}