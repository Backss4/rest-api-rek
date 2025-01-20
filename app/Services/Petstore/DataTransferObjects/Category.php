<?php

namespace App\Services\Petstore\DataTransferObjects;

use App\Services\Petstore\Exceptions\MalformedArrayException;
use App\Services\Petstore\Contracts\DataTransferObject;

class Category implements DataTransferObject
{
    public function __construct(
        public int     $id,
        public ?string $name,
    )
    {
    }

    public static function fromArray(array $data): Category
    {
        if (!isset($data['id'])) {
            throw new MalformedArrayException(static::class, $data);
        }

        return new static(
            $data['id'],
            data_get($data, 'name'),
        );
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
        ];
    }

    public function jsonSerialize(): array
    {
        return $this->toArray();
    }

    public function toJson($options = 0): string
    {
        return json_encode($this->jsonSerialize(), $options);
    }
}
