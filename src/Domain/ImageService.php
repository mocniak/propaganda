<?php

namespace Propaganda\Domain;

use Propaganda\Domain\Dto\NewImageRequest;
use Propaganda\Domain\Dto\NewImageResponse;
use Propaganda\Domain\Entity\Image;
use Propaganda\Domain\Repository\ImageRepositoryInterface;
use Propaganda\Domain\Storage\ImageFile;
use Propaganda\Domain\Storage\ImageStorageInterface;

class ImageService
{
    /**
     * @var ImageRepositoryInterface
     */
    private $repository;
    /**
     * @var ImageStorageInterface
     */
    private $storage;

    public function __construct(ImageRepositoryInterface $repository, ImageStorageInterface $storage)
    {
        $this->repository = $repository;
        $this->storage = $storage;
    }

    public function addImage(NewImageRequest $newImageRequest): NewImageResponse
    {
        $image = new Image($newImageRequest->description);
        $imageFile = new ImageFile($newImageRequest->mimeType, $newImageRequest->content);
        $this->storage->saveImageFile($image->getId(), $imageFile);
        $this->repository->save($image);
        return new NewImageResponse(true, $image->getId());
    }

    public function getImageFile($imageId): ImageFile
    {
        return $this->storage->loadImageFile($imageId);
    }
}