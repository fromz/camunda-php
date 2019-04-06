<?php
declare(strict_types=1);

use Camunda\ExternalTask;
use GuzzleHttp\Middleware;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

class FetchAndLockTest extends TestCase
{
    public function testRequestEncodedTopics()
    {
        $response = new GuzzleHttp\Psr7\Response(
            200,
            [],
            '{
              "activityId": "anActivityId",
              "activityInstanceId": "anActivityInstanceId",
            }'
        );
        $container = [];
        $history = Middleware::history($container);
        $mock = new GuzzleHttp\Handler\MockHandler([$response]);
        $handler = GuzzleHttp\HandlerStack::create($mock);
        $handler->push($history);

        $client = new GuzzleHttp\Client(['handler' => $handler]);

        $fetchAndLockRequest = new ExternalTask\FetchAndLockRequest();
        $fetchAndLockRequest->setWorkerId("PHP Worker");
        $fetchAndLockRequest->setMaxTasks(1);
        $topic = new ExternalTask\FetchAndLockRequestTopic();
        $topic->setTopicName('topic');
        $topic->setLockDuration(1000);
        $fetchAndLockRequest->addTopic($topic);

        $externalTaskService = new ExternalTask\ExternalTaskService($client);
        $externalTaskService->fetchAndLock($fetchAndLockRequest);

        $this->assertCount(1, $container);
        $firstRequest = $container[0]['request'];
        /* @var $firstRequest GuzzleHttp\Psr7\Request */
        $responseContent = $firstRequest->getBody()->getContents();
        $this->assertJson($responseContent);
        $sentPayload = json_decode($responseContent, true);
        $this->assertArrayHasKey('topics', $sentPayload);
        $this->assertIsArray($sentPayload['topics']);
        $this->assertCount(1, $sentPayload['topics']);
    }

    public function testSuccess()
    {
        $response = new GuzzleHttp\Psr7\Response(
            200,
            [],
            '{
              "activityId": "anActivityId",
              "activityInstanceId": "anActivityInstanceId",
            }'
        );
        $container = [];
        $history = Middleware::history($container);
        $mock = new GuzzleHttp\Handler\MockHandler([$response]);
        $handler = GuzzleHttp\HandlerStack::create($mock);
        $handler->push($history);

        $client = new GuzzleHttp\Client(['handler' => $handler]);

        $fetchAndLockRequest = new ExternalTask\FetchAndLockRequest();
        $fetchAndLockRequest->setWorkerId("PHP Worker");
        $fetchAndLockRequest->setMaxTasks(1);
        $topic = new ExternalTask\FetchAndLockRequestTopic();
        $topic->setTopicName('topic');
        $topic->setLockDuration(1000);
        $fetchAndLockRequest->addTopic($topic);

        $externalTaskService = new ExternalTask\ExternalTaskService($client);
        $externalTaskService->fetchAndLock($fetchAndLockRequest);

        $this->assertCount(1, $container);
        $firstRequest = $container[0]['request'];
        /* @var $firstRequest GuzzleHttp\Psr7\Request */
        $responseContent = $firstRequest->getBody()->getContents();
        $this->assertJson($responseContent);
        $sentPayload = json_decode($responseContent, true);
        $this->assertArrayHasKey('topics', $sentPayload);
        $this->assertIsArray($sentPayload['topics']);
        $this->assertCount(1, $sentPayload['topics']);
    }

}