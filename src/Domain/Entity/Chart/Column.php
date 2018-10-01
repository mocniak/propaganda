<?php
namespace Propaganda\Domain\Entity\Chart;

class Column
{
    const STRING_TYPE = 'string';
    const NUMBER_TYPE = 'number';
    const TYPES = [
        self::STRING_TYPE,
        self::NUMBER_TYPE
    ];

    private $name;
    private $type;

    public function __construct(string $name = null, string $type = null)
    {
        $this->name = $name;
        $this->type = $type;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function setType(string $type): void
    {
        $this->type = $type;
    }
}