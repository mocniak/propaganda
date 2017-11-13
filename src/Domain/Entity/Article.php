<?php
namespace Propaganda\Domain\Entity;

use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

class Article
{
    private $id;
    /**
     * @var string
     */
    private $title;
    /**
     * @var string
     */
    private $content;

    public function __construct(string $title, string $content)
    {
        $this->id = Uuid::uuid4();
        $this->title = $title;
        $this->content = $content;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getContent(): string
    {
        return $this->content;
    }

    public function getId(): UuidInterface
    {
        return $this->id;
    }
}