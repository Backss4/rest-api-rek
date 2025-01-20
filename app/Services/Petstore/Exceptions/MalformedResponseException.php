<?php

namespace App\Services\Petstore\Exceptions;

use Exception;
use Illuminate\Http\Client\RequestException as BaseRequestException;
use Illuminate\Http\Client\Response;

use App\Services\Petstore\DataTransferObjects\ApiResponse;

class MalformedResponseException extends BaseRequestException
{
    public ?ApiResponse $apiResponse;
    public $data;

    public function __construct(Response $response)
    {
        parent::__construct($response);
        $this->apiResponse = $this->prepareApiResponse($response);
        $this->data = $response->json();
    }

    protected function prepareApiResponse(Response $response): ?ApiResponse
    {
        if (!$response->successful()) {
            try {
                return ApiResponse::fromArray($response->json());
            } catch (Exception) {
                return null;
            }
        }

        return null;
    }
}
