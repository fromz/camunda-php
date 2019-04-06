<?php
/**
 * Created by PhpStorm.
 * User: kushalhalder
 * Date: 2019-01-22
 * Time: 18:01
 */

namespace Camunda\ExternalTask;

class ExternalTaskRequest
{
    protected $id;
    /**
     * The id of the worker on which behalf tasks are fetched. The returned
     * tasks are locked for that worker and can only be completed when
     * providing the same worker id.
     */
    protected $workerId;
    /**
     * The maximum number of tasks to return.
     */
    protected $maxTasks;
    /**
     * A boolean value, which indicates whether the task should be fetched
     * based on its priority or arbitrarily.
     */
    protected $usePriority;
    /**
     * A JSON array of topic objects for which external tasks should be
     * fetched. The returned tasks may be arbitrarily distributed among
     * these topics.
     */
    protected $topics;
    /**
     * An message indicating the reason of the failure.
     */
    protected $errorMessage;
    /**
     * A detailed error description.
     */
    protected $errorDetails;
    /**
     * A number of how often the task should be retried. Must be >= 0. If
     * this is 0, an incident is created and the task cannot be fetched
     * anymore unless the retries are increased again. The incident's message
     * is set to the errorMessage parameter.
     */
    protected $retries;
    /**
     * A timeout in milliseconds before the external task becomes available
     * again for fetching. Must be >= 0.
     */
    protected $retryTimeout;
    /**
     * A error code that indicates the predefined error. Is used to
     * identify the BPMN error handler.
     */
    protected $errorCode;


    public function __get($property)
    {
        if (property_exists($this, $property)) {
            return $this->$property;
        }

        throw new \Exception("$property is not a property of " . __CLASS__);
    }

    public function __set($property, $value)
    {
        if (property_exists($this, $property)) {
            $this->$property = $value;
        }

        return $this;
    }
}
