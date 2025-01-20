<?php

namespace App\Services\Petstore\DataTransferObjects;

use App\Services\Petstore\Contracts\DataTransferObject;
use App\Services\Petstore\Exceptions\MalformedArrayException;

class ApiResponse implements DataTransferObject
{
    public function __construct(
        public $code,
        public $type,
        public $message
    )
    {
    }

    public function toArray(): array
    {
        return [
            'code' => $this->code,
            'type' => $this->type,
            'message' => $this->message
        ];
    }

    public static function fromArray(array $data): ApiResponse
    {
        if (!isset($data['code'], $data['type'], $data['message'])) {
            throw new MalformedArrayException(self::class, $data);
        }

        return new self(
            $data['code'],
            $data['type'],
            $data['message']
        );
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
