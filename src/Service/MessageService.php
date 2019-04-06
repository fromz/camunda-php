<?php
/**
 * Created by IntelliJ IDEA.
 * User: hentschel
 * Date: 02.07.13
 * Time: 11:12
 * To change this template use File | Settings | File Templates.
 */

namespace Camunda\Service;

use Camunda\Client;
use Exception;
use Camunda\Request\MessageRequest;

class MessageService
{

    /**
     * @var Client
     */
    private $client;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    /**
     * Deliver a message to the process engine to either trigger a message
     * start or intermediate message catching event.
     * @link http://docs.camunda.org/api-references/rest/#!/message/post-message
     *
     * @param MessageRequest $request request body
     * @throws \Exception
     */
    public function deliverMessage(MessageRequest $request)
    {
        $this->client->setRequestUrl('/message');
        $this->client->setRequestMethod('POST');
        $this->client->setRequestData($request);

        try {
            $this->client->execute();
        } catch (Exception $e) {
            throw $e;
        }
    }
}
