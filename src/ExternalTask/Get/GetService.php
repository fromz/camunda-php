<?php

namespace Camunda\ExternalTask\Get;

use GuzzleHttp\Client;
use GuzzleHttp\RequestOptions;

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
        $path = sprintf('/external-task');
        try {
            $response = $this->guzzle->request('GET', $path, [RequestOptions::HTTP_ERRORS => false, RequestOptions::QUERY => $queryParameters->toArray()]);
            $jsonResponse = \json_decode($response->getBody()->getContents());

            return \Camunda\ExternalTask\Get\ExternalTask::fromArray($jsonResponse);
        } catch (\GuzzleHttp\Exception\GuzzleException $e) {
        } catch (\Exception $e) {
        }
    }

    public function getById(string $id)
    {
        $path = sprintf('/external-task/%s', $id);
        try {
            $response = $this->guzzle->request('GET', $path, [RequestOptions::HTTP_ERRORS => false]);
        } catch (\GuzzleHttp\Exception\GuzzleException $e) {
        } catch (\Exception $e) {
        }
    }
}
