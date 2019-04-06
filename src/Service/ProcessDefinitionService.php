<?php
/**
 * Created by IntelliJ IDEA.
 * User: hentschel
 * Date: 26.06.13
 * Time: 09:13
 * To change this template use File | Settings | File Templates.
 */

namespace Camunda\Service;

use Camunda\Client;
use Exception;
use Camunda\Request\ProcessDefinitionRequest;
use Camunda\Request\StatisticRequest;
use Camunda\Response\Form;
use Camunda\Response\ProcessDefinition;
use Camunda\Response\ProcessInstance;
use Camunda\Response\Statistic;

class ProcessDefinitionService
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
   * Retrieves a single process definition according to the
   * ProcessDefinition interface in the engine.
   * @link http://docs.camunda.org/api-references/rest/#!/process-definition/get
   *
   * @param String $id ID of the requested definition
   * @throws \Exception
   * @return \Camunda\Response\ProcessDefinition $this Requested definition
   */
    public function getDefinition($id)
    {
        $processDefinition = new ProcessDefinition();
        $this->client->setRequestUrl('/process-definition/'.$id);
        $this->client->setRequestData(null);
        $this->client->setRequestMethod('GET');

        try {
            return $processDefinition->cast($this->client->execute());
        } catch (Exception $e) {
            throw $e;
        }
    }

    /**
     * Retrieves a list of process definitions
     * @link http://docs.camunda.org/api-references/rest/#!/process-definition/get-query
     *
     * @param ProcessDefinitionRequest $request filter parameters
     * @throws \Exception
     * @return object list of retrieved process definitions
     */
    public function getDefinitions(ProcessDefinitionRequest $request)
    {
        $this->client->setRequestUrl('/process-definition/');
        $this->client->setRequestData($request);
        $this->client->setRequestMethod('GET');

        try {
            $prepare = $this->client->execute();
            $response = array();
            foreach ($prepare as $index => $data) {
                $processDefinition = new ProcessDefinition();
                $response['definition_' . $index] = $processDefinition->cast($data);
            }
            return (object)$response;
        } catch (Exception $e) {
            throw $e;
        }
    }

    /**
     * Request the number of process definitions that fulfill the query criteria.
     * @link http://docs.camunda.org/api-references/rest/#!/process-definition/get-query-count
     *
     * @param ProcessDefinitionRequest $request filtered parameters
     * @throws \Exception
     * @return int Amount of jobs
     */
    public function getCount(ProcessDefinitionRequest $request)
    {
        $this->client->setRequestUrl('/process-definition/count');
        $this->client->setRequestData($request);
        $this->client->setRequestMethod('GET');

        try {
            return $this->client->execute()->count;
        } catch (Exception $e) {
            throw $e;
        }
    }

    /**
     * Retrieves the BPMN 2.0 XML of this process definition.
     * @link http://docs.camunda.org/api-references/rest/#!/process-definition/get-xml
     *
     * @param String $id process definition ID
     * @throws \Exception
     * @return mixed
     */
    public function getBpmn20Xml($id)
    {
        $this->client->setRequestUrl('/process-definition/'.$id.'/xml');
        $this->client->setRequestMethod('GET');
        $this->client->setRequestData(null);

        try {
            return $this->client->execute();
        } catch (Exception $e) {
            throw $e;
        }
    }

    /**
     * Instantiates a given process definition.
     * @link http://docs.camunda.org/api-references/rest/#!/process-definition/post-start-process-instance
     *
     * @param String $id process definition ID
     * @param ProcessDefinitionRequest $request variables
     * @throws \Exception
     * @return \Camunda\Response\ProcessInstance $this started process instance
     */
    public function startInstance($id, ProcessDefinitionRequest $request)
    {
        $processInstance = new ProcessInstance();
        $this->client->setRequestUrl('/process-definition/'.$id.'/start');
        $this->client->setRequestData($request);
        $this->client->setRequestMethod('POST');

        try {
            return $processInstance->cast($this->client->execute());
        } catch (Exception $e) {
            throw $e;
        }
    }

    /**
     * Instantiates a given process definition.
     * @link http://docs.camunda.org/api-references/rest/#!/process-definition/post-start-process-instance
     *
     * @param String $key process definition key
     * @param ProcessDefinitionRequest $request variables
     * @throws \Exception
     * @return \Camunda\Response\ProcessInstance $this started process instance
     */
    public function startInstanceByKey($key, ProcessDefinitionRequest $request)
    {
        $processInstance = new ProcessInstance();
        $this->client->setRequestUrl('/process-definition/key/'.$key.'/start');
        $this->client->setRequestData($request);
        $this->client->setRequestMethod('POST');

        try {
            return $processInstance->cast($this->client->execute());
        } catch (Exception $e) {
            throw $e;
        }
    }



    /**
     * Retrieves process instances statistics
     * @link http://docs.camunda.org/api-references/rest/#!/process-definition/get-statistics
     *
     * @param StatisticRequest $request
     * @throws \Exception
     * @return object list of process instance statistics
     */
    public function getProcessInstanceStatistic(StatisticRequest $request)
    {
        $this->client->setRequestUrl('/process-definition/statistics');
        $this->client->setRequestData($request);
        $this->client->setRequestMethod('GET');

        try {
            $prepare = $this->client->execute();
            $response = array();
            foreach ($prepare as $index => $data) {
                $statistic = new Statistic();
                $response['statistic_' . $index] = $statistic->cast($data);
            }
            return (object)$response;
        } catch (Exception $e) {
            throw $e;
        }
    }

    /**
     * Get a list of activity instances statistics of the given process definition id
     * @link http://docs.camunda.org/api-references/rest/#!/process-definition/get-activity-statistics
     *
     * @param String $id process definition id
     * @param StatisticRequest $request parameters
     * @throws \Exception
     * @return object list of activity instance statistics
     */
    public function getActivityInstanceStatistic($id, StatisticRequest $request)
    {
        $this->client->setRequestUrl('/process-definition/'.$id.'/statistics');
        $this->client->setRequestData($request);
        $this->client->setRequestMethod('GET');

        try {
            $prepare = $this->client->execute();
            $response = array();
            foreach ($prepare as $index => $data) {
                $statistic = new Statistic();
                $response['statistic_' . $index] = $statistic->cast($data);
            }
            return (object)$response;
        } catch (Exception $e) {
            throw $e;
        }
    }

    /**
     * get form key of the start event
     * @link http://docs.camunda.org/api-references/rest/#!/process-definition/get-start-form-key
     * (Prepared for 7.1.0 - context Path will come ;) )
     *
     * @param String $id process definition ID
     * @throws \Exception
     * @return Form start form key
     */
    public function getStartFormKey($id)
    {
        $form = new Form();
        $this->client->setRequestUrl('/process-definition/'.$id.'/startForm');
        $this->client->setRequestData(null);
        $this->client->setRequestMethod('GET');

        try {
            return $form->cast($this->client->execute());
        } catch (Exception $e) {
            throw $e;
        }
    }
}
