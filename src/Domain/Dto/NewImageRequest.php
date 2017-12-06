<?php

namespace Propaganda\Domain\Dto;

class NewImageRequest
{
    public $mimeType;
    public $content;
    public $description;

    public function __construct(string $mimeType, $content, string $description)
    {
        $this->mimeType = $mimeType;
        $this->content = $content;
        $this->description = $description;
    }
}