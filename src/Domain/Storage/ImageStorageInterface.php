<?php

namespace Propaganda\Domain\Storage;

use Ramsey\Uuid\UuidInterface;

interface ImageStorageInterface
{
    public function saveImageFile(UuidInterface $imageId, ImageFile $file);

    public function loadImageFile(UuidInterface $imageId): ImageFile;
}