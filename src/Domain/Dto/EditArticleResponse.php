<?php

namespace Propaganda\Domain\Dto;


class EditArticleResponse
{
    public $success;
    public $id;

    public function __construct(bool $success, string $id)
    {
        $this->success = $success;
        $this->id = $id;
    }
}