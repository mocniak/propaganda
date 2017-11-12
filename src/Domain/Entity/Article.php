<?php
namespace Propaganda\Domain\Entity;

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
        $this->id = \Ramsey\Uuid\Uuid::uuid4();
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
}