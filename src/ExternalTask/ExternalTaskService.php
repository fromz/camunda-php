<?php
/**
 * Created by PhpStorm.
 * User: kushalhalder
 * Date: 2019-01-22
 * Time: 18:05.
 */

namespace Camunda\ExternalTask;

use Camunda\JsonDeserializerTrait;
use Camunda\JsonSerializerTrait;

class ExternalTaskService
{
    const EXTERNAL_TASK_URL = '/external-task/';

    const REQUEST_METHOD_GET = 'GET';

    const REQUEST_METHOD_POST = 'POST';

    const REQUEST_METHOD_PUT = 'PUT';

    use JsonDeserializerTrait;

    use JsonSerializerTrait;

    /**
     * @var \GuzzleHttp\Client
     */
    private $client;

    public function __construct(\GuzzleHttp\Client $client)
    {
        $this->client = $client;
    }

    /**
     * Retrieves an external task by id, corresponding to the
     * ExternalTask interface in the engine.
     *
     * @param string $id external task id
     *
     * @return ExternalTask
     *
     * @throws \Exception
     */
    public function get(string $id): FetchExternalTaskTopic
    {
        try {
            $response = $this->client->get(sprintf('/external-task/%s', $id));

            return $this->deserializeJson(
                FetchExternalTaskTopic::class,
                $response->getBody()->getContents()
            );
        } catch (\GuzzleHttp\Exception\ClientException $clientException) {
            if (null !== $clientException->getResponse() &&
                404 === $clientException->getResponse()->getStatusCode()) {
                throw new ExternalTaskNotFoundException(
                    sprintf('Task not found: %s', $id),
                    404,
                    $clientException
                );
            }
            throw $clientException;
        }
    }

    /**
     * Fetches and locks a specific number of external tasks for execution by
     * a worker. Query can be restricted to specific task topics and for each
     * task topic an individual lock time can be provided.
     *
     * @param FetchAndLockRequest $request
     *
     * @throws \Exception
     *
     * @todo return object
     */
    public function fetchAndLock(FetchAndLockRequest $request)
    {
        try {
            $response = $this->client->post('/external-task/fetchAndLock', [
                'headers' => ['Content-Type' => 'application/json'],
                'body' => $this->serializeToJson($request),
            ]);
        } catch (\GuzzleHttp\Exception\ClientException $clientException) {
            // @todo wrap exceptions
            throw $clientException;
        }
    }
}
