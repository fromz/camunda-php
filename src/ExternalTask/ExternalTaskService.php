<?php
/**
 * Created by PhpStorm.
 * User: kushalhalder
 * Date: 2019-01-22
 * Time: 18:05
 */

namespace Camunda\Service;

use Camunda\Request\ExternalTaskRequest;
use Camunda\Response\ExternalTask;

class ExternalTaskService
{
    const EXTERNAL_TASK_URL= '/external-task/';

    const REQUEST_METHOD_GET = 'GET';
    const REQUEST_METHOD_POST = 'POST';
    const REQUEST_METHOD_PUT = 'PUT';

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
     * @param String $id external task id
     * @return \Camunda\Response\ExternalTask
     * @throws \Exception
     */
    public function getExternalTask($id)
    {
        $externalTask = new ExternalTask();
        $this->client->setRequestUrl(self::EXTERNAL_TASK_URL . $id);
        $this->client->setRequestMethod(self::REQUEST_METHOD_GET);
        $this->client->setRequestData(null);

        try {
            return $externalTask->cast($this->client->execute());
        } catch (\Exception $e) {
            throw $e;
        }
    }

    /**
     * Fetches and locks a specific number of external tasks for execution by
     * a worker. Query can be restricted to specific task topics and for each
     * task topic an individual lock time can be provided.
     *
     * @param ExternalTaskRequest $request
     * @return object
     * @throws \Exception
     */
    public function fetchAndLockExternalTasks(ExternalTaskRequest $request)
    {
        $this->client->setRequestUrl(self::EXTERNAL_TASK_URL . 'fetchAndLock');
        $this->client->setRequestData($request);
        $this->client->setRequestMethod(self::REQUEST_METHOD_POST);

        try {
            $prepare = $this->client->execute();
            $response = [];

            foreach ($prepare as $index => $data) {
                $externalTask = new ExternalTask();
                $response['external_task_' . $index] = $externalTask->cast($data);
            }

            return (object)$response;
        } catch (\Exception $e) {
            throw $e;
        }
    }

    /**
     * Completes a task and updates process variables.
     *
     * @param $id
     * @param ExternalTaskRequest $request
     * @throws \Exception
     */
    public function handleBPMNError($id, ExternalTaskRequest $request)
    {
        $this->client->setRequestUrl(self::EXTERNAL_TASK_URL . $id . '/bpmnError');
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
     * @param ExternalTaskRequest $request
     * @throws \Exception
     */
    public function completeExternalTask($id, ExternalTaskRequest $request)
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
     * @param ExternalTaskRequest $request
     * @throws \Exception
     */
    public function externalTaskFailed($id, ExternalTaskRequest $request)
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
