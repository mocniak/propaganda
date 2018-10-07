<?php
namespace Propaganda\Domain\Entity;

use Ramsey\Uuid\Uuid;

class Chart
{
    const TYPE_PIE = 'pie';
    const TYPE_LINE = 'line';
    const TYPE_COLUMN = 'column';
    const TYPE_BAR = 'bar';

    private $id;
    private $name;
    private $columns;
    private $data;
    private $type;
    private $createdAt;

    public function __construct(string $name, array $columns, array $data, string $type)
    {
        $this->id = Uuid::uuid4();
        $this->name = $name;
        $this->columns = $columns;
        $this->data = $data;
        $this->type = $type;
        $this->createdAt = new \DateTimeImmutable();
    }

    public function getId(): \Ramsey\Uuid\UuidInterface
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getColumns(): array
    {
        return $this->columns;
    }

    public function getData(): array
    {
        return $this->data;
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function setColumns(array $columns): void
    {
        $this->columns = $columns;
    }

    public function setData(array $data): void
    {
        $this->data = $data;
    }

    public function setType(string $type): void
    {
        $this->type = $type;
    }

}