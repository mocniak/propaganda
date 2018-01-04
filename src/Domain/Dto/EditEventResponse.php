<?php
namespace Propaganda\Domain\Dto;

class EditEventResponse
{
    public $success;
    public $id;

    public function __construct(bool $success)
    {
        $this->success = $success;
    }
}