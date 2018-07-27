<?php

namespace Propaganda\Domain\Entity;

use Cocur\Slugify\Slugify;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

class Article
{
    private $id;
    private $title;
    private $coverImageId;
    private $content;
    private $createdAt;
    private $author;
    private $slug;
    private $public;

    public function __construct(string $title, array $content, string $author)
    {
        $this->id = Uuid::uuid4();
        $this->title = $title;
        $this->content = $content;
        $this->createdAt = new \DateTimeImmutable();
        $this->author = $author;
        $this->slug = (new Slugify())->slugify($title);
        $this->public = false;
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

    public function getSlug(): string
    {
        return $this->slug;
    }

    public function getAuthor(): string
    {
        return $this->author;
    }

    public function setSlug(string $slug): void
    {
        $this->slug = (new Slugify())->slugify($slug);
    }

    public function setAuthor(string $author): void
    {
        $this->author = $author;
    }

    public function publish()
    {
        $this->public = true;
    }

    public function withdraw()
    {
        $this->public = false;
    }

    public function isPublic(): bool
    {
        return $this->public === true;
    }
}