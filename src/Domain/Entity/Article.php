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
     * @var array
     */
    private $content;

    public function __construct(string $title, array $content)
    {
        $this->id = Uuid::uuid4();
        $this->title = $title;
        $this->content = $content;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getContent(): array
    {
        return $this->content;
    }

    public function getId(): UuidInterface
    {
        return $this->id;
    }

    public function setTitle(string $title)
    {
        $this->title = $title;
    }

    public function setContent(string $content)
    {
        $this->content = $content;
    }
}