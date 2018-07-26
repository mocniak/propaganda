<?php

namespace Propaganda\Domain;

use Propaganda\Domain\Dto\NewImageRequest;
use Propaganda\Domain\Dto\NewImageResponse;
use Propaganda\Domain\Dto\NewVideoRequest;
use Propaganda\Domain\Entity\Image;
use Propaganda\Domain\Entity\Video;
use Propaganda\Domain\Repository\ImageRepositoryInterface;
use Propaganda\Domain\Repository\VideoRepositoryInterface;
use Propaganda\Domain\Storage\ImageFile;
use Propaganda\Domain\Storage\ImageStorageInterface;
use Ramsey\Uuid\UuidInterface;

class VideoService
{
    /**
     * @var VideoRepositoryInterface
     */
    private $repository;

    public function __construct(VideoRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function addVideo(NewVideoRequest $newVideoRequest): void
    {
        $video = new Video($newVideoRequest->title, $newVideoRequest->description, $newVideoRequest->youtubeId);
        $this->repository->save($video);
    }

    public function getVideo(UuidInterface $videoId): Video
    {
        return $this->repository->get($videoId);
    }
}