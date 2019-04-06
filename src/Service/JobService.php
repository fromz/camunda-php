<?php
/**
 * Created by IntelliJ IDEA.
 * User: hentschel
 * Date: 22.07.13
 * Time: 11:38
 * To change this template use File | Settings | File Templates.
 */

namespace Camunda\Service;

use Camunda\Client;
use Exception;
use Camunda\Request\JobRequest;
use Camunda\Response\Job;

class JobService
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
   * Retrieves a job with given id.
   * @link http://docs.camunda.org/api-references/rest/#!/job/get
   *
   * @param String $id Job ID
   * @throws \Exception
   * @return \Camunda\Response\Job $this requested job
   */
    public function getJob($id)
    {
        $this->client->setRequestUrl('/job/'.$id);
        $this->client->setRequestData(null);
        $this->client->setRequestMethod('GET');

        $job = new Job();
        try {
            return $job->cast($this->client->execute());
        } catch (Exception $e) {
            throw $e;
        }
    }

    /**
     * Retrieves a list of jobs
     * @link http://docs.camunda.org/api-references/rest/#!/job/get-query
     * @link http://docs.camunda.org/api-references/rest/#!/job/post-query
     *
     * @param JobRequest $request Filter parameters
     * @param bool $isPostRequest switch for GET/POST request
     * @throws \Exception
     * @return object List of available jobs
     */
    public function getJobs(JobRequest $request, $isPostRequest = false)
    {
        $this->client->setRequestUrl('/job');
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
                $job = new Job();
                $response['job_' . $index] = $job->cast($data);
            }
            return (object)$response;
        } catch (Exception $e) {
            throw $e;
        }
    }

    /**
     * Retrieves the amount of jobs
     * @link http://docs.camunda.org/api-references/rest/#!/job/get-query-count
     * @link http://docs.camunda.org/api-references/rest/#!/job/post-query-count
     *
     * @param JobRequest $request Filter parameters
     * @param bool $isPostRequest switch for GET/POST request
     * @throws \Exception
     * @return int Amount of jobs
     */
    public function getCount(JobRequest $request, $isPostRequest = false)
    {
        $this->client->setRequestUrl('/job/count');
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
     * Sets the retries of the job to a given amount
     * @link http://docs.camunda.org/api-references/rest/#!/job/put-set-job-retries
     *
     * @param String $id job ID
     * @param JobRequest $request amount of retries
     * @throws \Exception
     */
    public function setRetries($id, JobRequest $request)
    {
        $this->client->setRequestUrl('/job/'.$id.'/retries');
        $this->client->setRequestData($request);
        $this->client->setRequestMethod('PUT');

        try {
            $this->client->execute();
        } catch (Exception $e) {
            throw $e;
        }
    }

    /**
     * executes the given job
     * @link http://docs.camunda.org/api-references/rest/#!/job/post-execute-job
     *
     * @param String $id job ID
     * @throws \Exception
     */
    public function executeJob($id)
    {
        $this->client->setRequestUrl('/job/'.$id.'/execute');
        $this->client->setRequestData(null);
        $this->client->setRequestMethod('POST');

        try {
            $this->client->execute();
        } catch (Exception $e) {
            throw $e;
        }
    }

    /**
     * Retrieves the corresponding exception stacktrace to the passed job id.
     * Output will be in plain/text
     * @link http://docs.camunda.org/latest/api-references/rest/#job-get-exception-stacktrace
     *
     * @param String $id job ID
     * @throws \Exception
     * @return String
     */
    public function getExceptionStacktrace($id)
    {
        $this->client->setRequestUrl('job/'.$id.'/stacktrace');
        $this->client->setRequestData(null);
        $this->client->setRequestMethod('GET');

        try {
            return $this->client->execute();
        } catch (Exception $e) {
            throw $e;
        }
    }

    /**
     * Updates the due date of a job
     * @link http://docs.camunda.org/latest/api-references/rest/#job-set-job-due-date
     *
     * @param String $id job ID
     * @param JobRequest $request
     * @throws \Exception
     */
    public function setDueDate($id, JobRequest $request)
    {
        $this->client->setRequestUrl('/job/'.$id.'/duedate');
        $this->client->setRequestData($request);
        $this->client->setRequestMethod('PUT');

        try {
            $this->client->execute();
        } catch (Exception $e) {
            throw $e;
        }
    }
}
