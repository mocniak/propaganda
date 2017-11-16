<?php

namespace Propaganda\Domain\Entity\Article;


class YoutubeVideo implements ContentInterface
{
    private $videoId;

    public function __construct(string $videoId)
    {
        $this->videoId = $videoId;
    }

    public function getVideoId(): string
    {
        return $this->videoId;
    }

    public function getType(): string
    {
        return 'youtubeVideo';
    }
}