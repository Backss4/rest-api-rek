<?php

namespace App\Services\Petstore\Exceptions;

use Exception;
use Illuminate\Http\Client\RequestException as BaseRequestException;
use Illuminate\Http\Client\Response;

use App\Services\Petstore\DataTransferObjects\ApiResponse;

class RequestException extends BaseRequestException
{
    public ?ApiResponse $apiResponse;

    public function __construct(Response $response)
    {
        parent::__construct($response);
        $this->apiResponse = $this->prepareApiResponse($response);
    }

    protected function prepareApiResponse(Response $response): ?ApiResponse
    {
        try {
            return ApiResponse::fromArray($response->json() ?? []);
        } catch (Exception) {
            return null;
        }
    }
}
