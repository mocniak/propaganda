<?php
namespace Propaganda\Domain\Entity;

use Ramsey\Uuid\Uuid;

class Chart
{
    private $id;
    private $name;
    private $columns;
    private $data;
    private $createdAt;

    public function __construct(string $name, array $columns, array $data)
    {
        $this->id = Uuid::uuid4();
        $this->name = $name;
        $this->columns = $columns;
        $this->data = $data;
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

}