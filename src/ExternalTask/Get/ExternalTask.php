<?php

namespace Camunda\ExternalTask\Get;

class ExternalTask implements \JsonSerializable
{
    /**
     * The id of the activity that this external task belongs to.
     *
     * @var string
     */
    private $activityId;

    /**
     * The id of the activity instance that the external task belongs to.
     *
     * @var string
     */
    private $activityInstanceId;

    /**
     * The error message that was supplied when the last failure of this task was reported.
     *
     * @var string
     */
    private $errorMessage;

    /**
     * @var string
     */
    private $errorDetails;

    /**
     * The id of the execution that the external task belongs to.
     *
     * @var string
     */
    private $executionId;

    /**
     * The id of the external task.
     *
     * @var string
     */
    private $id;

    /**
     * The date that the task's most recent lock expires or has expired.
     *
     * @var string
     */
    private $lockExpirationTime;

    /**
     * The id of the process definition the external task is defined in.
     *
     * @var string
     */
    private $processDefinitionId;

    /**
     * The key of the process definition the external task is defined in.
     *
     * @var string
     */
    private $processDefinitionKey;

    /**
     * The id of the process instance the external task belongs to.
     *
     * @var string
     */
    private $processInstanceId;

    /**
     * The number of retries the task currently has left.
     *
     * @var int
     */
    private $retries;

    /**
     * @var bool
     */
    private $suspended;

    /**
     * The id of the worker that posesses or posessed the most recent lock.
     *
     * @var string
     */
    private $workerId;

    /**
     * The topic name of the external task.
     *
     * @var string
     */
    private $topicName;

    /**
     * The id of the tenant the external task belongs to.
     *
     * @var string
     */
    private $tenantId;

    /**
     * The priority of the external task.
     *
     * @var int
     */
    private $priority;

    /**
     * The id of the activity that this external task belongs to.
     *
     * @var string
     *
     * @return ExternalTask
     */
    public function setActivityId(string $activityId): self
    {
        $this->activityId = $activityId;

        return $this;
    }

    /**
     * The id of the activity that this external task belongs to.
     *
     * @return string
     */
    public function getActivityId()
    {
        return $this->activityId;
    }

    /**
     * The id of the activity instance that the external task belongs to.
     *
     * @var string
     *
     * @return ExternalTask
     */
    public function setActivityInstanceId(string $activityInstanceId): self
    {
        $this->activityInstanceId = $activityInstanceId;

        return $this;
    }

    /**
     * The id of the activity instance that the external task belongs to.
     *
     * @return string
     */
    public function getActivityInstanceId()
    {
        return $this->activityInstanceId;
    }

    /**
     * The error message that was supplied when the last failure of this task was reported.
     *
     * @var string
     *
     * @return ExternalTask
     */
    public function setErrorMessage(string $errorMessage): self
    {
        $this->errorMessage = $errorMessage;

        return $this;
    }

    /**
     * The error message that was supplied when the last failure of this task was reported.
     *
     * @return string
     */
    public function getErrorMessage()
    {
        return $this->errorMessage;
    }

    /**
     * @var string
     *
     * @return ExternalTask
     */
    public function setErrorDetails(string $errorDetails): self
    {
        $this->errorDetails = $errorDetails;

        return $this;
    }

    /**
     * @return string
     */
    public function getErrorDetails()
    {
        return $this->errorDetails;
    }

    /**
     * The id of the execution that the external task belongs to.
     *
     * @var string
     *
     * @return ExternalTask
     */
    public function setExecutionId(string $executionId): self
    {
        $this->executionId = $executionId;

        return $this;
    }

    /**
     * The id of the execution that the external task belongs to.
     *
     * @return string
     */
    public function getExecutionId()
    {
        return $this->executionId;
    }

    /**
     * The id of the external task.
     *
     * @var string
     *
     * @return ExternalTask
     */
    public function setId(string $id): self
    {
        $this->id = $id;

        return $this;
    }

    /**
     * The id of the external task.
     *
     * @return string
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * The date that the task's most recent lock expires or has expired.
     *
     * @var string
     *
     * @return ExternalTask
     */
    public function setLockExpirationTime(string $lockExpirationTime): self
    {
        $this->lockExpirationTime = $lockExpirationTime;

        return $this;
    }

    /**
     * The date that the task's most recent lock expires or has expired.
     *
     * @return string
     */
    public function getLockExpirationTime()
    {
        return $this->lockExpirationTime;
    }

    /**
     * The id of the process definition the external task is defined in.
     *
     * @var string
     *
     * @return ExternalTask
     */
    public function setProcessDefinitionId(string $processDefinitionId): self
    {
        $this->processDefinitionId = $processDefinitionId;

        return $this;
    }

    /**
     * The id of the process definition the external task is defined in.
     *
     * @return string
     */
    public function getProcessDefinitionId()
    {
        return $this->processDefinitionId;
    }

    /**
     * The key of the process definition the external task is defined in.
     *
     * @var string
     *
     * @return ExternalTask
     */
    public function setProcessDefinitionKey(string $processDefinitionKey): self
    {
        $this->processDefinitionKey = $processDefinitionKey;

        return $this;
    }

    /**
     * The key of the process definition the external task is defined in.
     *
     * @return string
     */
    public function getProcessDefinitionKey()
    {
        return $this->processDefinitionKey;
    }

    /**
     * The id of the process instance the external task belongs to.
     *
     * @var string
     *
     * @return ExternalTask
     */
    public function setProcessInstanceId(string $processInstanceId): self
    {
        $this->processInstanceId = $processInstanceId;

        return $this;
    }

    /**
     * The id of the process instance the external task belongs to.
     *
     * @return string
     */
    public function getProcessInstanceId()
    {
        return $this->processInstanceId;
    }

    /**
     * The number of retries the task currently has left.
     *
     * @var int
     *
     * @return ExternalTask
     */
    public function setRetries(int $retries): self
    {
        $this->retries = $retries;

        return $this;
    }

    /**
     * The number of retries the task currently has left.
     *
     * @return int
     */
    public function getRetries()
    {
        return $this->retries;
    }

    /**
     * @var bool
     *
     * @return ExternalTask
     */
    public function setSuspended(bool $suspended): self
    {
        $this->suspended = $suspended;

        return $this;
    }

    /**
     * @return bool
     */
    public function getSuspended()
    {
        return $this->suspended;
    }

    /**
     * The id of the worker that posesses or posessed the most recent lock.
     *
     * @var string
     *
     * @return ExternalTask
     */
    public function setWorkerId(string $workerId): self
    {
        $this->workerId = $workerId;

        return $this;
    }

    /**
     * The id of the worker that posesses or posessed the most recent lock.
     *
     * @return string
     */
    public function getWorkerId()
    {
        return $this->workerId;
    }

    /**
     * The topic name of the external task.
     *
     * @var string
     *
     * @return ExternalTask
     */
    public function setTopicName(string $topicName): self
    {
        $this->topicName = $topicName;

        return $this;
    }

    /**
     * The topic name of the external task.
     *
     * @return string
     */
    public function getTopicName()
    {
        return $this->topicName;
    }

    /**
     * The id of the tenant the external task belongs to.
     *
     * @var string
     *
     * @return ExternalTask
     */
    public function setTenantId(string $tenantId): self
    {
        $this->tenantId = $tenantId;

        return $this;
    }

    /**
     * The id of the tenant the external task belongs to.
     *
     * @return string
     */
    public function getTenantId()
    {
        return $this->tenantId;
    }

    /**
     * The priority of the external task.
     *
     * @var int
     *
     * @return ExternalTask
     */
    public function setPriority(int $priority): self
    {
        $this->priority = $priority;

        return $this;
    }

    /**
     * The priority of the external task.
     *
     * @return int
     */
    public function getPriority()
    {
        return $this->priority;
    }

    public function jsonSerialize()
    {
        $json = array();
        if (null !== $this->activityId) {
            $json['activityId'] = $this->activityId;
        }
        if (null !== $this->activityInstanceId) {
            $json['activityInstanceId'] = $this->activityInstanceId;
        }
        if (null !== $this->errorMessage) {
            $json['errorMessage'] = $this->errorMessage;
        }
        if (null !== $this->errorDetails) {
            $json['errorDetails'] = $this->errorDetails;
        }
        if (null !== $this->executionId) {
            $json['executionId'] = $this->executionId;
        }
        if (null !== $this->id) {
            $json['id'] = $this->id;
        }
        if (null !== $this->lockExpirationTime) {
            $json['lockExpirationTime'] = $this->lockExpirationTime;
        }
        if (null !== $this->processDefinitionId) {
            $json['processDefinitionId'] = $this->processDefinitionId;
        }
        if (null !== $this->processDefinitionKey) {
            $json['processDefinitionKey'] = $this->processDefinitionKey;
        }
        if (null !== $this->processInstanceId) {
            $json['processInstanceId'] = $this->processInstanceId;
        }
        if (null !== $this->retries) {
            $json['retries'] = $this->retries;
        }
        if (null !== $this->suspended) {
            $json['suspended'] = $this->suspended;
        }
        if (null !== $this->workerId) {
            $json['workerId'] = $this->workerId;
        }
        if (null !== $this->topicName) {
            $json['topicName'] = $this->topicName;
        }
        if (null !== $this->tenantId) {
            $json['tenantId'] = $this->tenantId;
        }
        if (null !== $this->priority) {
            $json['priority'] = $this->priority;
        }

        return $json;
    }

    public static function fromArray(array $values): ExternalTask
    {
        $container = new ExternalTask();
        if (array_key_exists('activityId', $values)) {
            $container->setActivityId($values['activityId']);
        }
        if (array_key_exists('activityInstanceId', $values)) {
            $container->setActivityInstanceId($values['activityInstanceId']);
        }
        if (array_key_exists('errorMessage', $values)) {
            $container->setErrorMessage($values['errorMessage']);
        }
        if (array_key_exists('errorDetails', $values)) {
            $container->setErrorDetails($values['errorDetails']);
        }
        if (array_key_exists('executionId', $values)) {
            $container->setExecutionId($values['executionId']);
        }
        if (array_key_exists('id', $values)) {
            $container->setId($values['id']);
        }
        if (array_key_exists('lockExpirationTime', $values)) {
            $container->setLockExpirationTime($values['lockExpirationTime']);
        }
        if (array_key_exists('processDefinitionId', $values)) {
            $container->setProcessDefinitionId($values['processDefinitionId']);
        }
        if (array_key_exists('processDefinitionKey', $values)) {
            $container->setProcessDefinitionKey($values['processDefinitionKey']);
        }
        if (array_key_exists('processInstanceId', $values)) {
            $container->setProcessInstanceId($values['processInstanceId']);
        }
        if (array_key_exists('retries', $values)) {
            $container->setRetries($values['retries']);
        }
        if (array_key_exists('suspended', $values)) {
            $container->setSuspended($values['suspended']);
        }
        if (array_key_exists('workerId', $values)) {
            $container->setWorkerId($values['workerId']);
        }
        if (array_key_exists('topicName', $values)) {
            $container->setTopicName($values['topicName']);
        }
        if (array_key_exists('tenantId', $values)) {
            $container->setTenantId($values['tenantId']);
        }
        if (array_key_exists('priority', $values)) {
            $container->setPriority($values['priority']);
        }

        return $container;
    }
}
