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
        $chart->setType($request->type);
        $this->repository->save($chart);
    }

    public function addEmptyChart(): UuidInterface
    {
        $chart = new Chart(
            'Chart Name',
            [
                new Column('Column 1', Column::STRING_TYPE),
                new Column('Column 2', Column::NUMBER_TYPE)
            ],
            [
                ['First Row', 12],
                ['Second Row', 10]
            ],
            Chart::TYPE_COLUMN
        );
        $this->repository->save($chart);

        return $chart->getId();
    }
}