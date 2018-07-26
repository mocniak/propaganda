<?php

namespace Propaganda\Domain\Dto;

use Propaganda\Domain\Entity\Video;
use Ramsey\Uuid\UuidInterface;

class EditVideoRequest
{
    public $videoId;
    public $youtubeId;
    public $title;
    public $description;

    public function __construct(UuidInterface $videoId, string $youtubeId, string $title, string $description)
    {
        $this->videoId = $videoId;
        $this->youtubeId = $youtubeId;
        $this->title = $title;
        $this->description = $description;
    }

    public static function fromVideo(Video $video): self
    {
        return new self($video->getId(), $video->getYoutubeId(), $video->getTitle(), $video->getDescription());
    }
}