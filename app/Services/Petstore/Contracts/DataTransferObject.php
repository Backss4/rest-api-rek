<?php

namespace App\Services\Petstore\Contracts;

use App\Services\Petstore\Exceptions\MalformedArrayException;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Contracts\Support\Jsonable;

interface DataTransferObject extends Arrayable, Jsonable, \JsonSerializable
{
    /**
     * @param array $data
     * @return DataTransferObject
     *
     * @throws MalformedArrayException
     */
    public static function fromArray(array $data): DataTransferObject;
}
