<?php
/**
 * Created by IntelliJ IDEA.
 * User: hentschel
 * Date: 30.10.13
 * Time: 13:25
 * To change this template use File | Settings | File Templates.
 */

namespace Camunda\Service;

use Camunda\Client;
use Exception;
use Camunda\Request\HistoricActivityInstanceRequest;
use Camunda\Request\HistoricProcessInstanceRequest;
use Camunda\Request\HistoricVariableInstanceRequest;
use Camunda\Request\HistoricActivityStatisticRequest;
use Camunda\Response\HistoricActivityInstance;
use Camunda\Response\HistoricProcessInstance;
use Camunda\Response\HistoricVariableInstance;
use Camunda\Response\HistoricActivityStatistic;

class HistoryService
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
   * Query for historic activity instances that fulfill the given parameters.
   * @link http://docs.camunda.org/latest/api-references/rest/#history-get-activity-instances-historic
   *
   * @param HistoricActivityInstanceRequest $request
   * @throws \Exception
   * @return object
   */
    public function getActivityInstances(HistoricActivityInstanceRequest $request)
    {
        $this->client->setRequestUrl('/history/activity-instance');
        $this->client->setRequestData($request);
        $this->getRequestMethod('GET');

        try {
            $prepare = $this->client->execute();
            $response = array();
            foreach ($prepare as $index => $data) {
                $historicActivityInstance = new HistoricActivityInstance();
                $response['historicActivityInstance_'.$index] = $historicActivityInstance->cast($data);
            }
            return (object)$response;
        } catch (Exception $e) {
            throw $e;
        }
    }

    /**
     * Query for the number of historic activity instances that fulfill the given parameters.
     * @link http://docs.camunda.org/latest/api-references/rest/#history-get-activity-instances-count
     *
     * @param HistoricActivityInstanceRequest $request
     * @throws \Exception
     * @return Integer count
     */
    public function getActivityInstancesCount(HistoricActivityInstanceRequest $request)
    {
        $this->client->setRequestUrl('/history/activity-instance/count');
        $this->client->setRequestData($request);
        $this->getRequestMethod('GET');

        try {
            return $this->client->execute()->count;
        } catch (Exception $e) {
            throw $e;
        }
    }

    /**
     * Query for historic process instances that fulfill the given parameters.
     * @link http://docs.camunda.org/latest/api-references/rest/#history-get-process-instances
     * @link http://docs.camunda.org/latest/api-references/rest/#history-get-process-instances-post
     *
     * @param HistoricProcessInstanceRequest $request
     * @param bool $isPostRequest
     * @throws \Exception
     * @return object
     */
    public function getProcessInstances(HistoricProcessInstanceRequest $request, $isPostRequest = false)
    {
        $this->client->setRequestUrl('/history/process-instance');
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
                $historicProcessInstance = new HistoricProcessInstance();
                $response['historicProcessInstance_' . $index] = $historicProcessInstance->cast($data);
            }
            return (object)$response;
        } catch (Exception $e) {
            throw $e;
        }
    }

    /**
     * Query for the number of historic process instances that fulfill the given parameters.
     * @link http://docs.camunda.org/latest/api-references/rest/#history-get-process-instances-count
     * @link http://docs.camunda.org/latest/api-references/rest/#history-get-process-instances-count-post
     *
     * @param HistoricProcessInstanceRequest $request
     * @param bool $isPostRequest
     * @throws \Exception
     * @return mixed
     */
    public function getProcessInstancesCount(HistoricProcessInstanceRequest $request, $isPostRequest = false)
    {
        $this->client->setRequestUrl('/history/process-instance/count');
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
     * Query for historic variable instances that fulfill the given parameters.
     * @link http://docs.camunda.org/latest/api-references/rest/#history-get-variable-instances
     * @link http://docs.camunda.org/latest/api-references/rest/#history-get-variable-instances-post
     *
     * @param HistoricVariableInstanceRequest $request
     * @param bool $isPostRequest
     * @throws \Exception
     * @return object
     */
    public function getVariableInstances(HistoricVariableInstanceRequest $request, $isPostRequest = false)
    {
        $this->client->setRequestUrl('/history/variable-instance');
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
                $historicVariableInstance = new HistoricVariableInstance();
                $response['historicVariableInstance_' . $index] = $historicVariableInstance->cast($data);
            }
            return (object)$response;
        } catch (Exception $e) {
            throw $e;
        }
    }

    /**
     * Query for the number of historic variable instances that fulfill the given parameters.
     * @link http://docs.camunda.org/latest/api-references/rest/#history-get-variable-instances-count
     * @link http://docs.camunda.org/latest/api-references/rest/#history-get-variable-instances-count-post
     *
     * @param HistoricVariableInstanceRequest $request
     * @param bool $isPostRequest
     * @throws \Exception
     * @return mixed
     */
    public function getVariableInstancesCount(HistoricVariableInstanceRequest $request, $isPostRequest = false)
    {
        $this->client->setRequestUrl('/history/variable-instance/count');
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
     * Get a list of historic activity instances statistics of the given process definition id
     * @link http://docs.camunda.org/api-references/rest/#history-get-historic-activity-statistics
     *
     * @param String $id process definition id
     * @param HistoricActivityStatisticRequest $request parameters
     * @throws \Exception
     * @return object list of historic activity instance statistics
     */
    public function getHistoricActivityStatistic($id, HistoricActivityStatisticRequest $request)
    {
        $this->client->setRequestUrl('/history/process-definition/'.$id.'/statistics');
        $this->client->setRequestData($request);
        $this->client->setRequestMethod('GET');

        try {
            $prepare = $this->client->execute();
            $response = array();
            foreach ($prepare as $index => $data) {
                $statistic = new HistoricActivityStatistic();
                $response['statistic_' . $index] = $statistic->cast($data);
            }
            return (object)$response;
        } catch (Exception $e) {
            throw $e;
        }
    }
}
