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
     * @var UuidInterface
     */
    private $coverImageId;
    /**
     * @var array
     */
    private $content;
    /**
     * @var \DateTimeImmutable
     */
    private $createdAt;

    public function __construct(string $title, array $content)
    {
        $this->id = Uuid::uuid4();
        $this->title = $title;
        $this->content = $content;
        $this->createdAt = new \DateTimeImmutable();
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

    public function setContent(array $content)
    {
        $this->content = $content;
    }

    public function getCoverImageId(): ?UuidInterface
    {
        return $this->coverImageId;
    }

    public function setCoverImageId(UuidInterface $coverImageId): void
    {
        $this->coverImageId = $coverImageId;
    }

    public function getCreatedAt(): \DateTimeImmutable
    {
        return $this->createdAt;
    }
}