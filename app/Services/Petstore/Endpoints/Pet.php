<?php

namespace App\Services\Petstore\Endpoints;

use App\Services\Petstore\DataTransferObjects\Status;
use App\Services\Petstore\Exceptions\MalformedArrayException;
use App\Services\Petstore\Exceptions\MalformedResponseException;
use Exception;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Http\Client\PendingRequest;
use Illuminate\Support\Facades\Log;

use App\Services\Petstore\Exceptions\RequestException;
use App\Services\Petstore\DataTransferObjects\Pet as PetDTO;

class Pet
{
    /**
     * @var string
     */
    private const ENDPOINT = '/pet';

    /**
     * @var PendingRequest
     */
    private PendingRequest $client;

    /**
     * @param PendingRequest $request
     */
    public function __construct(PendingRequest $request)
    {
        $this->client = $request;
    }

    /**
     * @param int $id
     * @return PetDTO
     *
     * @throws ConnectionException
     * @throws RequestException
     * @throws MalformedResponseException
     */
    public function get(int $id): PetDTO
    {
        $response = $this->client->withUrlParameters([
            'id' => $id,
        ])->get(self::ENDPOINT . '/{id}');

        if ($response->failed()) {
            throw new RequestException($response);
        }

        try {
            return PetDTO::fromArray($response->json() ?? []);
        } catch (MalformedArrayException) {
            throw new MalformedResponseException($response);
        }
    }


    /**
     * @param PetDTO $pet
     * @return PetDTO
     *
     * @throws ConnectionException
     * @throws RequestException
     * @throws MalformedResponseException
     */
    public function create(PetDTO $pet): PetDTO
    {
        $response = $this->client->post(self::ENDPOINT, $pet->toArray());

        if ($response->failed()) {
            throw new RequestException($response);
        }

        try {
            return PetDTO::fromArray($response->json() ?? []);
        } catch (MalformedArrayException) {
            throw new MalformedResponseException($response);
        }
    }

    /**
     * @param PetDTO $pet
     * @return PetDTO
     *
     * @throws ConnectionException
     * @throws RequestException
     * @throws MalformedResponseException
     */
    public function update(PetDTO $pet): PetDTO
    {
        $response = $this->client->put(self::ENDPOINT, $pet->toArray());

        if ($response->failed()) {
            throw new RequestException($response);
        }

        try {
            return PetDTO::fromArray($response->json() ?? []);
        } catch (MalformedArrayException) {
            throw new MalformedResponseException($response);
        }
    }

    /**
     * @param string $id
     * @param string $name
     * @param Status $status
     * @return void
     *
     * @throws ConnectionException
     * @throws RequestException
     */
    public function partialUpdate(string $id, string $name, Status $status): void
    {
        $response = $this->client->withUrlParameters([
            'id' => $id,
        ])->asForm()->post(self::ENDPOINT . '/{id}', [
            'name' => $name,
            'status' => $status->value
        ]);

        if ($response->failed()) {
            throw new RequestException($response);
        }
    }

    /**
     * @param int $id
     * @return void
     *
     * @throws ConnectionException
     * @throws RequestException
     */
    public function delete(int $id): void
    {
        $response = $this->client->withUrlParameters([
            'id' => $id,
        ])->delete(self::ENDPOINT . '/{id}');

        if ($response->failed()) {
            throw new RequestException($response);
        }
    }
}
