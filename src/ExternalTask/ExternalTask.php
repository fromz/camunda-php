<?php
/**
 * Created by PhpStorm.
 * User: kushalhalder
 * Date: 2019-01-22
 * Time: 18:07
 */

namespace Camunda\Response;

class ExternalTask
{
    /**
     * String	The id of the activity that this external task belongs to.
     */
    protected $activityId;
    /**
     * String	The id of the activity instance that the external task belongs to.
     */
    protected $activityInstanceId;
    /**
     * String	The full error message submitted with the latest reported failure executing this task;
     */
    protected $errorMessage;
    /**
     * String	The error details submitted with the latest reported failure executing this task.
     */
    protected $errorDetails;
    /**
     * String	The id of the execution that the external task belongs to.
     */
    protected $executionId;
    /**
     * String	The id of the external task.
     */
    protected $id;
    /**
     * String	The date that the task's most recent lock expires or has expired.
     */
    protected $lockExpirationTime;
    /**
     * String	The id of the process definition the external task is defined in.
     */
    protected $processDefinitionId;
    /**
     * String	The key of the process definition the external task is defined in.
     */
    protected $processDefinitionKey;
    /**
     * String	The id of the process instance the external task belongs to.
     */
    protected $processInstanceId;
    /**
     * String	The id of the tenant the external task belongs to.
     */
    protected $tenantId;
    /**
     * String	The id of the worker that posesses or posessed the most recent lock.
     */
    protected $workerId;
    /**
     * Number	The number of retries the task currently has left.
     */
    protected $retries;
    /**
     * Boolean	A flag indicating whether the external task is suspended or not.
     */
    protected $suspended;
    /**
     * Number	The priority of the external task.
     */
    protected $priority;
    /**
     * String	The topic name of the external task.
     */
    protected $topicName;

    /**
     * Object   A JSON object containing a property for each of the requested
     * variables. The key is the variable name, the value is a JSON object of
     * serialized variable values
     */
    protected $variables;

    public function __get($property)
    {
        if (property_exists($this, $property)) {
            return $this->$property;
        }
    }

    public function __set($property, $value)
    {
        if (property_exists($this, $property)) {
            $this->$property = $value;
        }

        return $this;
    }
}
