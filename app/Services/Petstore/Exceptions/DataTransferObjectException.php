<?php

namespace App\Services\Petstore\Exceptions;

class DataTransferObjectException extends \RuntimeException
{
    public function __construct($message, $code = 0, \Exception $previous = null)
    {
        parent::__construct($message ?? 'DTO Exception', $code, $previous);
    }
}
