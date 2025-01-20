<?php

namespace App\Services\Petstore\Exceptions;

use App\Services\Petstore\Contracts\DataTransferObject;

class MalformedArrayException extends DataTransferObjectException
{
    protected array $data;

    public function __construct(string $cls, array $data)
    {
        parent::__construct($this->prepareMessage($cls));
        $this->data = $data;
    }

    protected function prepareMessage(string $cls): string
    {
        return "Class " . class_basename($cls) . " got malformed array.";
    }
}
