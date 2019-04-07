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
    public function get(string $id): ExternalTask
    {
        try {
            $response = $this->client->get(sprintf('/external-task/%s', $id));

            return $this->deserializeJson(
                ExternalTask::class,
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

    /**
     * Completes a task and updates process variables.
     *
     * @param $id
     * @param FetchAndLockRequest $request
     *
     * @throws \Exception
     */
    public function handleBPMNError($id, FetchAndLockRequest $request)
    {
        $this->client->setRequestUrl(self::EXTERNAL_TASK_URL.$id.'/bpmnError');
        $this->client->setRequestMethod(self::REQUEST_METHOD_POST);
        $this->client->setRequestData($request);

        try {
            $this->client->execute();
        } catch (\Exception $e) {
            throw $e;
        }
    }

    /**
     * Completes an external task by id and updates process variables.
     *
     * @param $id
     * @param FetchAndLockRequest $request
     *
     * @throws \Exception
     */
    public function completeExternalTask($id, FetchAndLockRequest $request)
    {
        $this->client->setRequestUrl(self::EXTERNAL_TASK_URL.$id.'/complete');
        $this->client->setRequestData($request);
        $this->client->setRequestMethod('POST');

        try {
            $this->client->execute();
        } catch (Exception $e) {
            throw $e;
        }
    }

    /**
     * Reports a failure to execute an external task by id. A number of
     * retries and a timeout until the task can be retried can be specified.
     * If retries are set to 0, an incident for this task is created.
     *
     * @param $id
     * @param FetchAndLockRequest $request
     *
     * @throws \Exception
     */
    public function externalTaskFailed($id, FetchAndLockRequest $request)
    {
        $this->client->setRequestUrl(self::EXTERNAL_TASK_URL.$id.'/failure');
        $this->client->setRequestData($request);
        $this->client->setRequestMethod('POST');

        try {
            $this->client->execute();
        } catch (Exception $e) {
            throw $e;
        }
    }
}
