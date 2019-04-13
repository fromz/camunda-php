<?php

namespace Camunda\ExternalTask\Get;

use GuzzleHttp\Client;

class GetService
{
    /**
     * @var Client
     */
    private $guzzle;

    public function __construct(Client $guzzle)
    {
        $this->guzzle = $guzzle;
    }

    /**
     * @returns \Camunda\ExternalTask\Get\ExternalTask
     *
     * @throws \Camunda\ExternalTask\Get\GetExternalTaskResponseException
     */
    public function getList(\Camunda\ExternalTask\Get\GetListParams $queryParameters): \Camunda\ExternalTask\Get\ExternalTask
    {
    }

    public function getById(string $id)
    {
    }
}
