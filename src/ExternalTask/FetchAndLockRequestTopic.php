<?php
/**
 * Created by PhpStorm.
 * User: fromz
 * Date: 7/04/19
 * Time: 7:20 AM
 */

namespace Camunda\ExternalTask;


class FetchAndLockRequestTopic
{
    /**
     * Mandatory. The topic's name.
     * @var string
     */
    protected $topicName;

    /**
     * Mandatory. The duration to lock the external tasks for in milliseconds.
     * @var int
     */
    protected $lockDuration;

    /**
     * A JSON array of String values that represent variable names. For each result task belonging to this topic, the given variables are returned as well if they are accessible from the external task's execution. If not provided - all variables will be fetched.
     * @var array|null
     */
    protected $variables;

    /**
     * If true only local variables will be fetched.
     * @var bool
     */
    protected $localVariables = false;

    /**
     * A String value which enables the filtering of tasks based on process instance business key.
     * @var string|null
     */
    protected $businessKey;

    /**
     * Filter tasks based on process definition id.
     * @var string|null
     */
    protected $processDefinitionId;

    /**
     * Filter tasks based on process definition ids.
     * @var string|null
     */
    protected $processDefinitionIdIn;

    /**
     * Filter tasks based on process definition key
     * @var string|null
     */
    protected $processDefinitionKey;

    /**
     * Filter tasks based on process definition keys.
     * @var string|null
     */
    protected $processDefinitionKeyIn;

    /**
     * @var string|null
     */
    protected $withoutTenantId;

    /**
     * Filter tasks based on tenant ids.
     * @var string|null
     */
    protected $tenantIdIn;

    /**
     * Key value pairs
     * A JSON object used for filtering tasks based on process instance variable values. A property name of the object represents a process variable name, while the property value represents the process variable value to filter tasks by.
     * @var array|null
     */
    protected $processVariables;

    /**
     * Determines whether serializable variable values (typically variables that store custom Java objects) should be deserialized on server side (default false).
     * If set to true, a serializable variable will be deserialized on server side and transformed to JSON using Jackson's POJO/bean property introspection feature. Note that this requires the Java classes of the variable value to be on the REST API's classpath.
     * If set to false, a serializable variable will be returned in its serialized format. For example, a variable that is serialized as XML will be returned as a JSON string containing XML.
     * @var bool
     */
    protected $deserializeValues = false;

    /**
     * @return string
     */
    public function getTopicName(): string
    {
        return $this->topicName;
    }

    /**
     * @param string $topicName
     * @return FetchAndLockRequestTopic
     */
    public function setTopicName(string $topicName): FetchAndLockRequestTopic
    {
        $this->topicName = $topicName;
        return $this;
    }

    /**
     * @return int
     */
    public function getLockDuration(): int
    {
        return $this->lockDuration;
    }

    /**
     * @param int $lockDuration
     * @return FetchAndLockRequestTopic
     */
    public function setLockDuration(int $lockDuration): FetchAndLockRequestTopic
    {
        $this->lockDuration = $lockDuration;
        return $this;
    }

    /**
     * @return array|null
     */
    public function getVariables(): ?array
    {
        return $this->variables;
    }

    /**
     * @param array|null $variables
     * @return FetchAndLockRequestTopic
     */
    public function setVariables(?array $variables): FetchAndLockRequestTopic
    {
        $this->variables = $variables;
        return $this;
    }

    /**
     * @return bool
     */
    public function isLocalVariables(): bool
    {
        return $this->localVariables;
    }

    /**
     * @param bool $localVariables
     * @return FetchAndLockRequestTopic
     */
    public function setLocalVariables(bool $localVariables): FetchAndLockRequestTopic
    {
        $this->localVariables = $localVariables;
        return $this;
    }

    /**
     * @return null|string
     */
    public function getBusinessKey(): ?string
    {
        return $this->businessKey;
    }

    /**
     * @param null|string $businessKey
     * @return FetchAndLockRequestTopic
     */
    public function setBusinessKey(?string $businessKey): FetchAndLockRequestTopic
    {
        $this->businessKey = $businessKey;
        return $this;
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
     * @return FetchAndLockRequestTopic
     */
    public function setProcessDefinitionId(?string $processDefinitionId): FetchAndLockRequestTopic
    {
        $this->processDefinitionId = $processDefinitionId;
        return $this;
    }

    /**
     * @return null|string
     */
    public function getProcessDefinitionIdIn(): ?string
    {
        return $this->processDefinitionIdIn;
    }

    /**
     * @param null|string $processDefinitionIdIn
     * @return FetchAndLockRequestTopic
     */
    public function setProcessDefinitionIdIn(?string $processDefinitionIdIn): FetchAndLockRequestTopic
    {
        $this->processDefinitionIdIn = $processDefinitionIdIn;
        return $this;
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
     * @return FetchAndLockRequestTopic
     */
    public function setProcessDefinitionKey(?string $processDefinitionKey): FetchAndLockRequestTopic
    {
        $this->processDefinitionKey = $processDefinitionKey;
        return $this;
    }

    /**
     * @return null|string
     */
    public function getProcessDefinitionKeyIn(): ?string
    {
        return $this->processDefinitionKeyIn;
    }

    /**
     * @param null|string $processDefinitionKeyIn
     * @return FetchAndLockRequestTopic
     */
    public function setProcessDefinitionKeyIn(?string $processDefinitionKeyIn): FetchAndLockRequestTopic
    {
        $this->processDefinitionKeyIn = $processDefinitionKeyIn;
        return $this;
    }

    /**
     * @return null|string
     */
    public function getWithoutTenantId(): ?string
    {
        return $this->withoutTenantId;
    }

    /**
     * @param null|string $withoutTenantId
     * @return FetchAndLockRequestTopic
     */
    public function setWithoutTenantId(?string $withoutTenantId): FetchAndLockRequestTopic
    {
        $this->withoutTenantId = $withoutTenantId;
        return $this;
    }

    /**
     * @return null|string
     */
    public function getTenantIdIn(): ?string
    {
        return $this->tenantIdIn;
    }

    /**
     * @param null|string $tenantIdIn
     * @return FetchAndLockRequestTopic
     */
    public function setTenantIdIn(?string $tenantIdIn): FetchAndLockRequestTopic
    {
        $this->tenantIdIn = $tenantIdIn;
        return $this;
    }

    /**
     * @return array|null
     */
    public function getProcessVariables(): ?array
    {
        return $this->processVariables;
    }

    /**
     * @param array|null $processVariables
     * @return FetchAndLockRequestTopic
     */
    public function setProcessVariables(?array $processVariables): FetchAndLockRequestTopic
    {
        $this->processVariables = $processVariables;
        return $this;
    }

    /**
     * @return bool
     */
    public function isDeserializeValues(): bool
    {
        return $this->deserializeValues;
    }

    /**
     * @param bool $deserializeValues
     * @return FetchAndLockRequestTopic
     */
    public function setDeserializeValues(bool $deserializeValues): FetchAndLockRequestTopic
    {
        $this->deserializeValues = $deserializeValues;
        return $this;
    }



}