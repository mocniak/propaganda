<?php
/**
 * Created by PhpStorm.
 * User: mocniak
 * Date: 06.12.17
 * Time: 20:15
 */

namespace Propaganda\Domain\Storage;


class ImageFile
{
    private $mimeType;
    private $content;

    public function __construct(string $mimeType, $content)
    {
        $this->mimeType = $mimeType;
        $this->content = $content;
    }

    public function getMimeType(): string
    {
        return $this->mimeType;
    }

    /* returns binary content of an image */
    public function getContent()
    {
        return $this->content;
    }
}