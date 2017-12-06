<?php

namespace Propaganda\Infrastructure\Storage;

use Propaganda\Domain\Storage\ImageFile;
use Propaganda\Domain\Storage\ImageStorageInterface;
use Ramsey\Uuid\UuidInterface;

class FileImageStorage implements ImageStorageInterface
{
    private $imageFolderPath;

    public function __construct(string $imageFolderPath)
    {
        $this->imageFolderPath = $imageFolderPath;
    }

    public function saveImageFile(UuidInterface $imageId, ImageFile $file)
    {
        if (!is_dir($this->imageFolderPath)) {
            mkdir($this->imageFolderPath . '/content/', 0777, true);
            mkdir($this->imageFolderPath . '/mimeTypes/', 0777, true);
        }

        file_put_contents($this->imageFolderPath . '/content/' . $imageId->toString(), $file->getContent());
        file_put_contents($this->imageFolderPath . '/mimeTypes/' . $imageId->toString(), $file->getMimeType());
    }

    public function loadImageFile(UuidInterface $imageId): ImageFile
    {
        $content = file_get_contents($this->imageFolderPath . '/content/' . $imageId->toString());
        $mimeType = file_get_contents($this->imageFolderPath . '/mimeTypes/' . $imageId->toString());
        return new ImageFile($mimeType, $content);
    }
}