<?php

namespace App\Services\Petstore\DataTransferObjects;

use App\Services\Petstore\Exceptions\MalformedArrayException;
use App\Services\Petstore\Contracts\DataTransferObject;
use Illuminate\Support\Collection;

class Pet implements DataTransferObject
{
    public function __construct(
        public int       $id,
        public ?string   $name,
        public ?Category $category,
        public Collection     $photoUrls,
        public Collection     $tags,
        public ?Status   $status
    )
    {
    }

    public static function fromArray(array $data): Pet
    {
        if (!isset($data['id'])) {
            throw new MalformedArrayException(static::class, $data);
        }

        /** @var Category|null $category */
        $category = optional(data_get($data, 'category'), function (array $rawData) {
            return Category::fromArray($rawData);
        });

        /** @var Collection $tags */
        $tags = tap(new Collection(), function (Collection $tags) use ($data) {
            foreach (data_get($data, 'tags', []) as $tag) {
                $tags->push(Tag::fromArray($tag));
            }
        });

        return new static(
            $data['id'],
            data_get($data, 'name'),
            $category,
            new Collection(data_get($data, 'photoUrls', [])),
            $tags,
            Status::tryFrom(data_get($data, 'status'))
        );

    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'category' => $this->category?->toArray(),
            'photoUrls' => $this->photoUrls->toArray(),
            'tags' => $this->tags->toArray(),
            'status' => $this->status?->value
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
