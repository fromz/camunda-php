<?php
/**
 * Created by IntelliJ IDEA.
 * User: hentschel
 * Date: 26.06.13
 * Time: 14:19
 * To change this template use File | Settings | File Templates.
 */

namespace Camunda\Service;

use Camunda\Client;
use Exception;
use Camunda\Request\ExecutionRequest;
use Camunda\Request\VariableRequest;
use Camunda\Request\MessageSubscriptionRequest;
use Camunda\Response\Execution;
use Camunda\Response\Variable;
use Camunda\Response\MessageSubscription;

class ExecutionService
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
   * Requests a single execution with a given ID
   * @link http://docs.camunda.org/api-references/rest/#!/execution/get
   *
   * @param String $id ID of requested execution
   * @throws \Exception
   * @return Execution $this requested execution
   */
    public function getExecution($id)
    {
        $execution = new Execution();
        $this->client->setRequestUrl('/execution/'.$id);
        $this->client->setRequestData(null);
        $this->client->setRequestMethod('GET');

        try {
            return $execution->cast($this->client->execute());
        } catch (Exception $e) {
            throw $e;
        }
    }

    /**
     * Requests a list of Executions
     * @link http://docs.camunda.org/api-references/rest/#!/execution/get-query
     * @link http://docs.camunda.org/api-references/rest/#!/execution/post-query
     *
     * @param \org\camunda\php\sdk\entity\request\ExecutionRequest $request Filter parameters
     * @param bool $isPostRequest Switch for POST/GET request
     * @throws \Exception
     * @return object List of all executions
     */
    public function getExecutions(ExecutionRequest $request, $isPostRequest = false)
    {
        $this->client->setRequestUrl('/execution/');
        $this->client->setRequestData($request);
        if ($isPostRequest == true) {
            $this->client->setRequestMethod('POST');
        } else {
            $this->client->setRequestMethod('GET');
        }

        try {
            $prepare = $this->client->execute();
            $response = array();
            foreach ($prepare as $index => $data) {
                $execution = new Execution();
                $response['execution_' . $index] = $execution->cast($data);
            }
            return (object)$response;
        } catch (Exception $e) {
            throw $e;
        }
    }

    /**
     * Requests the amount of executions
     * @link http://docs.camunda.org/api-references/rest/#!/execution/get-query-count
     * @link http://docs.camunda.org/api-references/rest/#!/execution/post-query-count
     *
     * @param \org\camunda\php\sdk\entity\request\ExecutionRequest $request Filter parameters
     * @param bool $isPostRequest Switch for POST/GET request
     * @throws \Exception
     * @return int count of the executions
     */
    public function getCount(ExecutionRequest $request, $isPostRequest = false)
    {
        $this->client->setRequestUrl('/execution/count/');
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

    /**
     * Requests a single execution variable
     * @link http://docs.camunda.org/api-references/rest/#!/execution/get-local-variable
     *
     * @param String $id ID of the execution which contains the requested variable
     * @param String $variableId ID of the requested variable
     * @throws \Exception
     * @return \Camunda\Response\Variable $this Requested variable
     */
    public function getExecutionVariable($id, $variableId)
    {
        $variable = new Variable();
        $this->client->setRequestUrl('/execution/'.$id.'/localVariables/'.$variableId);
        $this->client->setRequestData(null);
        $this->client->setRequestMethod('GET');

        try {
            return $variable->cast($this->client->execute());
        } catch (Exception $e) {
            throw $e;
        }
    }

    /**
     * Sets a variable in the context of a given execution.
     * @link http://docs.camunda.org/api-references/rest/#!/execution/put-local-variable
     *
     * @param String $id The id of the execution to set the variable for.
     * @param String $variableId The name of the variable to set.
     * @param VariableRequest $request request body
     * @throws \Exception
     */
    public function putExecutionVariable($id, $variableId, VariableRequest $request)
    {
        $this->client->setRequestUrl('/execution/'.$id.'/localVariables/'.$variableId);
        $this->client->setRequestData($request);
        $this->client->setRequestMethod('PUT');

        try {
            $this->client->execute();
        } catch (Exception $e) {
            throw $e;
        }
    }

    /**
     * Removes a variable in the context of a given execution
     * @link http://docs.camunda.org/api-references/rest/#!/execution/delete-local-variable
     *
     * @param String $id Execution ID
     * @param String $variableId Variable ID
     * @throws \Exception
     */
    public function deleteExecutionVariable($id, $variableId)
    {
        $this->client->setRequestUrl('/execution/'.$id.'/localVariables/'.$variableId);
        $this->client->setRequestData(null);
        $this->client->setRequestMethod('DELETE');

        try {
            $this->client->execute();
        } catch (Exception $e) {
            throw $e;
        }
    }

    /**
     * Retrieves all variables of a given execution
     * @link http://docs.camunda.org/api-references/rest/#!/execution/get-local-variables
     *
     * @param String $id Execution ID
     * @throws \Exception
     * @return object List of variables
     */
    public function getExecutionVariables($id)
    {
        $this->client->setRequestUrl('/execution/'.$id.'/localVariables');
        $this->client->setRequestData(null);
        $this->client->setRequestMethod('GET');

        try {
            $prepare = $this->client->execute();
            $response = array();
            foreach ($prepare as $index => $data) {
                $variable = new Variable();
                $response['variable_'.$index] = $variable->cast($data);
            }
            return (object) $response;
        } catch (Exception $e) {
            throw $e;
        }
    }

    /**
     * Updates or deletes the variables in the context of an execution.
     * Updates precede deletes. So if a variable is updated AND deleted,
     * the deletion overrides the update.
     * @link http://docs.camunda.org/api-references/rest/#!/execution/post-local-variables
     *
     * @param String $id execution ID
     * @param VariableRequest $request request body with modifications and/or deletions
     * @throws \Exception
     */
    public function updateOrDeleteExecutionVariables($id, VariableRequest $request)
    {
        $this->client->setRequestUrl('/execution/'.$id.'/localVariables');
        $this->client->setRequestData($request);
        $this->client->setRequestMethod('POST');

        try {
            $this->client->execute();
        } catch (Exception $e) {
            throw $e;
        }
    }

    /**
     * Signals a single execution. Can for example be used to explicitly
     * skip user tasks or signal asynchronous continuations.
     * @link http://docs.camunda.org/api-references/rest/#!/execution/post-signal
     *
     * @param String $id id of the execution
     * @throws \Exception
     */
    public function triggerExecution($id)
    {
        $this->client->setRequestUrl('/execution/'.$id .'/signal');
        $this->client->setRequestMethod('POST');
        $this->client->setRequestData(null);

        try {
            $this->client->execute();
        } catch (Exception $e) {
            throw $e;
        }
    }

    /**
     * Get a message event subscription for a specific execution and a message name.
     * @link http://docs.camunda.org/api-references/rest/#!/execution/get-message-subscription
     *
     * @param String $id Execution ID
     * @param String $messageName The name of the message that the subscription corresponds to.
     * @throws \Exception
     * @return \Camunda\Response\MessageSubscription $this requested MessageSubscription
     */
    public function getMessageEventSubscription($id, $messageName)
    {
        $messageSubscription = new MessageSubscription();
        $this->client->setRequestUrl('/execution/'.$id.'/messageSubscriptions/'.$messageName);
        $this->client->setRequestMethod('GET');
        $this->client->setRequestData(null);

        try {
            return $messageSubscription->cast($this->client->execute());
        } catch (Exception $e) {
            throw $e;
        }
    }

    /**
     * Deliver a message to a specific execution to trigger an existing message
     * event subscription. Inject process variables as the message's payload.
     * @link http://docs.camunda.org/api-references/rest/#!/execution/post-message
     *
     * @param String $id The id of the execution to submit the message to.
     * @param String $messageName The name of the message that the addressed subscription corresponds to.
     * @param MessageSubscriptionRequest $request request body
     * @throws \Exception
     */
    public function triggerMessageSubscription($id, $messageName, MessageSubscriptionRequest $request)
    {
        $this->client->setRequestUrl('/execution/'.$id.'/messageSubscriptions/'.$messageName.'/trigger');
        $this->client->setRequestMethod('POST');
        $this->client->setRequestData($request);

        try {
            $this->client->execute();
        } catch (Exception $e) {
            throw $e;
        }
    }
}
