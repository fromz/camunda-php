<?php
/**
 * Created by PhpStorm.
 * User: kushalhalder
 * Date: 2019-01-22
 * Time: 18:07
 */

namespace Camunda\ExternalTask;

class ExternalTask
{

    /**
     * String	The id of the activity that this external task belongs to.
     * @var string|null
     */
    protected $activityId;

    /**
     * String	The id of the activity instance that the external task belongs to.
     * @var string|null
     */
    protected $activityInstanceId;

    /**
     * String	The full error message submitted with the latest reported failure executing this task;
     * @var string|null
     */
    protected $errorMessage;

    /**
     * String	The error details submitted with the latest reported failure executing this task.
     * @var string|null
     */
    protected $errorDetails;

    /**
     * String	The id of the execution that the external task belongs to.
     * @var string|null
     */
    protected $executionId;

    /**
     * String	The id of the external task.
     * @var string|null
     */
    protected $id;

    /**
     * String	The date that the task's most recent lock expires or has expired.
     * @var string|null
     */
    protected $lockExpirationTime;

    /**
     * String	The id of the process definition the external task is defined in.
     * @var string|null
     */
    protected $processDefinitionId;

    /**
     * String	The key of the process definition the external task is defined in.
     * @var string|null
     */
    protected $processDefinitionKey;

    /**
     * String	The id of the process instance the external task belongs to.
     * @var string|null
     */
    protected $processInstanceId;

    /**
     * String	The id of the tenant the external task belongs to.
     * @var string|null
     */
    protected $tenantId;

    /**
     * String	The id of the worker that posesses or posessed the most recent lock.
     * @var string|null
     */
    protected $workerId;

    /**
     * Number	The number of retries the task currently has left.
     * @var int|null
     */
    protected $retries;

    /**
     * Boolean	A flag indicating whether the external task is suspended or not.
     * @var bool|null
     */
    protected $suspended;

    /**
     * Number	The priority of the external task.
     * @var int|null
     */
    protected $priority;

    /**
     * String	The topic name of the external task.
     * @var string|null
     */
    protected $topicName;

    /**
     * Object   A JSON object containing a property for each of the requested
     * variables. The key is the variable name, the value is a JSON object of
     * serialized variable values
     */
    protected $variables;

    /**
     * @return null|string
     */
    public function getActivityId(): ?string
    {
        return $this->activityId;
    }

    /**
     * @param null|string $activityId
     */
    public function setActivityId(?string $activityId): void
    {
        $this->activityId = $activityId;
    }

    /**
     * @return null|string
     */
    public function getActivityInstanceId(): ?string
    {
        return $this->activityInstanceId;
    }

    /**
     * @param null|string $activityInstanceId
     */
    public function setActivityInstanceId(?string $activityInstanceId): void
    {
        $this->activityInstanceId = $activityInstanceId;
    }

    /**
     * @return null|string
     */
    public function getErrorMessage(): ?string
    {
        return $this->errorMessage;
    }

    /**
     * @param null|string $errorMessage
     */
    public function setErrorMessage(?string $errorMessage): void
    {
        $this->errorMessage = $errorMessage;
    }

    /**
     * @return null|string
     */
    public function getErrorDetails(): ?string
    {
        return $this->errorDetails;
    }

    /**
     * @param null|string $errorDetails
     */
    public function setErrorDetails(?string $errorDetails): void
    {
        $this->errorDetails = $errorDetails;
    }

    /**
     * @return null|string
     */
    public function getExecutionId(): ?string
    {
        return $this->executionId;
    }

    /**
     * @param null|string $executionId
     */
    public function setExecutionId(?string $executionId): void
    {
        $this->executionId = $executionId;
    }

    /**
     * @return null|string
     */
    public function getId(): ?string
    {
        return $this->id;
    }

    /**
     * @param null|string $id
     */
    public function setId(?string $id): void
    {
        $this->id = $id;
    }

    /**
     * @return null|string
     */
    public function getLockExpirationTime(): ?string
    {
        return $this->lockExpirationTime;
    }

    /**
     * @param null|string $lockExpirationTime
     */
    public function setLockExpirationTime(?string $lockExpirationTime): void
    {
        $this->lockExpirationTime = $lockExpirationTime;
    }

    /**
     * @return null|string
     */
    public function getProcessDefinitionId(): ?string
    {
        return $this->processDefinitionId;
    }

    /**
     * @param null|string $processDefinitionId
     */
    public function setProcessDefinitionId(?string $processDefinitionId): void
    {
        $this->processDefinitionId = $processDefinitionId;
    }

    /**
     * @return null|string
     */
    public function getProcessDefinitionKey(): ?string
    {
        return $this->processDefinitionKey;
    }

    /**
     * @param null|string $processDefinitionKey
     */
    public function setProcessDefinitionKey(?string $processDefinitionKey): void
    {
        $this->processDefinitionKey = $processDefinitionKey;
    }

    /**
     * @return null|string
     */
    public function getProcessInstanceId(): ?string
    {
        return $this->processInstanceId;
    }

    /**
     * @param null|string $processInstanceId
     */
    public function setProcessInstanceId(?string $processInstanceId): void
    {
        $this->processInstanceId = $processInstanceId;
    }

    /**
     * @return null|string
     */
    public function getTenantId(): ?string
    {
        return $this->tenantId;
    }

    /**
     * @param null|string $tenantId
     */
    public function setTenantId(?string $tenantId): void
    {
        $this->tenantId = $tenantId;
    }

    /**
     * @return null|string
     */
    public function getWorkerId(): ?string
    {
        return $this->workerId;
    }

    /**
     * @param null|string $workerId
     */
    public function setWorkerId(?string $workerId): void
    {
        $this->workerId = $workerId;
    }

    /**
     * @return int|null
     */
    public function getRetries(): ?int
    {
        return $this->retries;
    }

    /**
     * @param int|null $retries
     */
    public function setRetries(?int $retries): void
    {
        $this->retries = $retries;
    }

    /**
     * @return bool|null
     */
    public function getSuspended(): ?bool
    {
        return $this->suspended;
    }

    /**
     * @param bool|null $suspended
     */
    public function setSuspended(?bool $suspended): void
    {
        $this->suspended = $suspended;
    }

    /**
     * @return int|null
     */
    public function getPriority(): ?int
    {
        return $this->priority;
    }

    /**
     * @param int|null $priority
     */
    public function setPriority(?int $priority): void
    {
        $this->priority = $priority;
    }

    /**
     * @return null|string
     */
    public function getTopicName(): ?string
    {
        return $this->topicName;
    }

    /**
     * @param null|string $topicName
     */
    public function setTopicName(?string $topicName): void
    {
        $this->topicName = $topicName;
    }

    /**
     * @return mixed
     */
    public function getVariables()
    {
        return $this->variables;
    }

    /**
     * @param mixed $variables
     */
    public function setVariables($variables): void
    {
        $this->variables = $variables;
    }



}
