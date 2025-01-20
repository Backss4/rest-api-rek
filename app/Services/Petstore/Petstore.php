<?php

namespace App\Services\Petstore;

use Exception;

use Illuminate\Http\Client\ConnectionException;
use Illuminate\Http\Client\PendingRequest;
use Illuminate\Support\Facades\Http;

use App\Services\Petstore\Endpoints\Pet;
use Throwable;


class Petstore
{
    /**
     * @var PendingRequest
     */
    protected PendingRequest $client;

    /**
     * @var array
     */
    protected array $endpoints = [];

    /**
     * @param string $baseUrl
     * @param int|float $connectTimeout
     * @param int|float $timeout
     * @param int $retries
     * @param int $retryDelay
     * @param string|null $token
     */
    public function __construct(string $baseUrl, int|float $connectTimeout, int|float $timeout, int $retries, int $retryDelay, string|null $token = null)
    {
        $retryDelay = max($retryDelay, 100);
        $this->client = Http::baseUrl($baseUrl)
            ->connectTimeout($connectTimeout)
            ->timeout($timeout)
            ->retry($retries, $retryDelay, function (Throwable $exception, PendingRequest $request) {
                return $exception instanceof ConnectionException;
            }, false)
            ->asJson()
            ->acceptJson();

        if (!is_null($token)) {
            $this->client->withHeader('api_key', $token);
        }

        $this->endpoints[Pet::class] = new Pet($this->client);
    }

    /**
     * @return Pet
     */
    public function pet(): Pet
    {
        return $this->endpoints[Pet::class];
    }
}
