<?php
/**
 * Created by IntelliJ IDEA.
 * User: hentschel
 * Date: 22.07.13
 * Time: 11:37
 * To change this template use File | Settings | File Templates.
 */

namespace Camunda\Service;

use Camunda\Client;
use Exception;
use Camunda\Request\VariableInstanceRequest;
use Camunda\Response\VariableInstance;

class VariableInstanceService
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
   * Retrieves all variable instances within given context
   * @link http://docs.camunda.org/api-references/rest/#!/variable-instance/get-query
   * @link http://docs.camunda.org/api-references/rest/#!/variable-instance/post-query
   *
   * @param VariableInstanceRequest $request filter parameters
   * @param bool $isPostRequest switch for GET/POST request
   * @throws \Exception
   * @return object list of variable instances
   */
    public function getInstances(VariableInstanceRequest $request, $isPostRequest = false)
    {
        $this->client->setRequestUrl('/variable-instance');
        $this->client->setRequestData($request);
        if ($isPostRequest == true) {
            $this->client->setRequestMethod('POST');
        } else {
            $this->client->setRequestMethod('GET');
        }

        try {
            $prepare = $this->client->execute();
            $response = array();
            $variableInstance = new VariableInstance();
            foreach ($prepare as $index => $data) {
                $response['instance_' . $index] = $variableInstance->cast($data);
            }
            return (object)$response;
        } catch (Exception $e) {
            throw $e;
        }
    }

    /**
     * Retrieves the amount of variable instances
     * @link http://docs.camunda.org/api-references/rest/#!/variable-instance/get-query-count
     * @link http://docs.camunda.org/api-references/rest/#!/variable-instance/post-query-count
     *
     * @param VariableInstanceRequest $request filter parameters
     * @param bool $isPostRequest switch for GET/POST request
     * @throws \Exception
     * @return int Amount of variable instances
     */
    public function getCount(VariableInstanceRequest $request, $isPostRequest = false)
    {
        $this->client->setRequestUrl('/variable-instance/count');
        $this->client->setRequestData($request);
        if ($isPostRequest == true) {
            $this->client->setRequestMethod('POST');
        } else {
            $this->client->setRequestMethod('GET');
        }

        try {
            return $this->client->execute()->count;
        } catch (Exception $e) {
            throw $e;
        }
    }
}
