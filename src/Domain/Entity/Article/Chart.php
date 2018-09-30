<?php
namespace Propaganda\Domain\Entity\Article;

use Ramsey\Uuid\UuidInterface;

class Chart implements ContentInterface
{
    private $id;

    public function __construct(UuidInterface $id)
    {
        $this->id = $id;
    }

    public function getType(): string
    {
        return 'chart';
    }

    public function getValue(): string
    {
        return $this->id->toString();
    }
}