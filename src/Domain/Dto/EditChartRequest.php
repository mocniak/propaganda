<?php

namespace Propaganda\Domain\Dto;

use Propaganda\Domain\Entity\Chart;
use Ramsey\Uuid\UuidInterface;

class EditChartRequest
{
    /**
     * @var UuidInterface
     */
    public $id;
    /**
     * @var string
     */
    public $name;
    /**
     * @var Chart\Column[]
     */
    public $columns;
    /**
     * @var array
     */
    public $data;
    /**
     * @var string
     */
    public $type;

    /**
     * EditChartRequest constructor.
     * @param UuidInterface $id
     * @param string $name
     * @param Chart\Column[] $columns
     * @param array $data
     * @param string $type
     */
    public function __construct(UuidInterface $id, string $name, array $columns, array $data, string $type)
    {
        $this->id = $id;
        $this->name = $name;
        $this->columns = $columns;
        $this->data = $data;
        $this->type = $type;
    }

    public static function fromChart(Chart $chart): self
    {
        return new self($chart->getId(), $chart->getName(), $chart->getColumns(), $chart->getData(), $chart->getType());
    }
}