<?php
/**
 * Created by IntelliJ IDEA.
 * User: hentschel
 * Date: 02.07.13
 * Time: 11:08
 * To change this template use File | Settings | File Templates.
 */

namespace Camunda\Service;

use Camunda\Client;
use Exception;

class ProcessEngineService
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
   * Retrieves a list of all available engines
   * @link http://docs.camunda.org/api-references/rest/#!/engine/get-names
   *
   * @throws \Exception
   * @return object List of engines
   */
    public function getEngineNames()
    {
        $this->client->setRequestUrl('/engine');
        $this->client->setRequestMethod("GET");
        $this->client->setRequestData(null);

        try {
            $prepare = $this->client->execute();
            $response = array();
            foreach ($prepare as $index => $data) {
                $response['engine_' . $index] = $data;
            }
            return (object)$response;
        } catch (Exception $e) {
            throw $e;
        }
    }
}
