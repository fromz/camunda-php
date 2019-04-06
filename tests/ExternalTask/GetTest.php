<?php
declare(strict_types=1);

use Camunda\ExternalTask;
use PHPUnit\Framework\TestCase;

class GetTest extends TestCase
{
    public function testSuccess()
    {
        $response = new GuzzleHttp\Psr7\Response(
            200,
            [],
            '{
              "activityId": "anActivityId",
              "activityInstanceId": "anActivityInstanceId",
              "errorMessage": "anErrorMessage",
              "errorDetails": "anErrorDetails",
              "executionId": "anExecutionId",
              "id": "anExternalTaskId",
              "lockExpirationTime": "2015-10-06T16:34:42.000+0200",
              "processDefinitionId": "aProcessDefinitionId",
              "processDefinitionKey": "aProcessDefinitionKey",
              "processInstanceId": "aProcessInstanceId",
              "tenantId": null,
              "retries": 3,
              "suspended": false,
              "workerId": "aWorkerId",
              "priority":0,
              "topicName": "aTopic",
              "businessKey": "aBusinessKey"
            }'
        );
        $mock = new GuzzleHttp\Handler\MockHandler([$response]);

        $handler = GuzzleHttp\HandlerStack::create($mock);
        $client = new GuzzleHttp\Client(['handler' => $handler]);

        $externalTaskService = new ExternalTask\ExternalTaskService($client);
        $externalTask = $externalTaskService->get('1');
        $this->assertInstanceOf(ExternalTask\ExternalTask::class, $externalTask);
        $this->assertEquals("anActivityId", $externalTask->getActivityId());
    }

    public function testNotFoundException()
    {
        $response = new GuzzleHttp\Psr7\Response(404);
        $mock = new GuzzleHttp\Handler\MockHandler([$response]);

        $handler = GuzzleHttp\HandlerStack::create($mock);
        $client = new GuzzleHttp\Client(['handler' => $handler]);

        $this->expectException(ExternalTask\ExternalTaskNotFoundException::class);
        $externalTaskService = new ExternalTask\ExternalTaskService($client);
        $externalTaskService->get('1');
    }
}