<?php

namespace \Camunda\ExternalTask;

class GetExternalTaskQueryParams
{
    /**
     * @var int
     */
    private $firstResult;

    /**
     * @var int
     */
    private $maxResults;

    /**
     * @var string
     */
    private $processInstanceId;

    /**
     * @var string
     */
    private $processDefinitionId;

    /**
     * @var string
     */
    private $workerId;

    /**
     * @var string
     */
    private $withRetriesLeft;

    /**
     * @var string
     */
    private $notLocked;

    /**
     * @var string
     */
    private $lockExpirationAfter;

    /**
     * @var string
     */
    private $active;

    /**
     * @var string
     */
    private $suspended;

    /**
     * @var string
     */
    private $activityId;

    /**
     * @var string
     */
    private $executionId;

    /**
     * @var string
     */
    private $priorityLowerThanOrEquals;

    /**
     * @var string
     */
    private $priorityHigherThanOrEquals;

    /**
     * @var string
     */
    private $lockExpirationBefore;

    /**
     * @var string
     */
    private $tenantIdIn;

    /**
     * @var string
     */
    private $sortOrder;

    /**
     * @var string
     */
    private $topicName;

    /**
     * @var string
     */
    private $sortBy;

    /**
     * @var string
     */
    private $noRetriesLeft;

    /**
     * @var string
     */
    private $externalTaskId;

    /**
     * @var string
     */
    private $locked;

    /**
     * @var string
     */
    private $activityIdIn;

    /**
     * @var int
     *
     * @return GetExternalTaskQueryParams
     */
    public function setFirstResult(int $firstResult): self
    {
        $this->firstResult = $firstResult;

        return $this;
    }

    /**
     * @return int
     */
    public function getFirstResult()
    {
        return $this->firstResult;
    }

    /**
     * @var int
     *
     * @return GetExternalTaskQueryParams
     */
    public function setMaxResults(int $maxResults): self
    {
        $this->maxResults = $maxResults;

        return $this;
    }

    /**
     * @return int
     */
    public function getMaxResults()
    {
        return $this->maxResults;
    }

    /**
     * @var string
     *
     * @return GetExternalTaskQueryParams
     */
    public function setProcessInstanceId(string $processInstanceId): self
    {
        $this->processInstanceId = $processInstanceId;

        return $this;
    }

    /**
     * @return string
     */
    public function getProcessInstanceId()
    {
        return $this->processInstanceId;
    }

    /**
     * @var string
     *
     * @return GetExternalTaskQueryParams
     */
    public function setProcessDefinitionId(string $processDefinitionId): self
    {
        $this->processDefinitionId = $processDefinitionId;

        return $this;
    }

    /**
     * @return string
     */
    public function getProcessDefinitionId()
    {
        return $this->processDefinitionId;
    }

    /**
     * @var string
     *
     * @return GetExternalTaskQueryParams
     */
    public function setWorkerId(string $workerId): self
    {
        $this->workerId = $workerId;

        return $this;
    }

    /**
     * @return string
     */
    public function getWorkerId()
    {
        return $this->workerId;
    }

    /**
     * @var string
     *
     * @return GetExternalTaskQueryParams
     */
    public function setWithRetriesLeft(string $withRetriesLeft): self
    {
        $this->withRetriesLeft = $withRetriesLeft;

        return $this;
    }

    /**
     * @return string
     */
    public function getWithRetriesLeft()
    {
        return $this->withRetriesLeft;
    }

    /**
     * @var string
     *
     * @return GetExternalTaskQueryParams
     */
    public function setNotLocked(string $notLocked): self
    {
        $this->notLocked = $notLocked;

        return $this;
    }

    /**
     * @return string
     */
    public function getNotLocked()
    {
        return $this->notLocked;
    }

    /**
     * @var string
     *
     * @return GetExternalTaskQueryParams
     */
    public function setLockExpirationAfter(string $lockExpirationAfter): self
    {
        $this->lockExpirationAfter = $lockExpirationAfter;

        return $this;
    }

    /**
     * @return string
     */
    public function getLockExpirationAfter()
    {
        return $this->lockExpirationAfter;
    }

    /**
     * @var string
     *
     * @return GetExternalTaskQueryParams
     */
    public function setActive(string $active): self
    {
        $this->active = $active;

        return $this;
    }

    /**
     * @return string
     */
    public function getActive()
    {
        return $this->active;
    }

    /**
     * @var string
     *
     * @return GetExternalTaskQueryParams
     */
    public function setSuspended(string $suspended): self
    {
        $this->suspended = $suspended;

        return $this;
    }

    /**
     * @return string
     */
    public function getSuspended()
    {
        return $this->suspended;
    }

    /**
     * @var string
     *
     * @return GetExternalTaskQueryParams
     */
    public function setActivityId(string $activityId): self
    {
        $this->activityId = $activityId;

        return $this;
    }

    /**
     * @return string
     */
    public function getActivityId()
    {
        return $this->activityId;
    }

    /**
     * @var string
     *
     * @return GetExternalTaskQueryParams
     */
    public function setExecutionId(string $executionId): self
    {
        $this->executionId = $executionId;

        return $this;
    }

    /**
     * @return string
     */
    public function getExecutionId()
    {
        return $this->executionId;
    }

    /**
     * @var string
     *
     * @return GetExternalTaskQueryParams
     */
    public function setPriorityLowerThanOrEquals(string $priorityLowerThanOrEquals): self
    {
        $this->priorityLowerThanOrEquals = $priorityLowerThanOrEquals;

        return $this;
    }

    /**
     * @return string
     */
    public function getPriorityLowerThanOrEquals()
    {
        return $this->priorityLowerThanOrEquals;
    }

    /**
     * @var string
     *
     * @return GetExternalTaskQueryParams
     */
    public function setPriorityHigherThanOrEquals(string $priorityHigherThanOrEquals): self
    {
        $this->priorityHigherThanOrEquals = $priorityHigherThanOrEquals;

        return $this;
    }

    /**
     * @return string
     */
    public function getPriorityHigherThanOrEquals()
    {
        return $this->priorityHigherThanOrEquals;
    }

    /**
     * @var string
     *
     * @return GetExternalTaskQueryParams
     */
    public function setLockExpirationBefore(string $lockExpirationBefore): self
    {
        $this->lockExpirationBefore = $lockExpirationBefore;

        return $this;
    }

    /**
     * @return string
     */
    public function getLockExpirationBefore()
    {
        return $this->lockExpirationBefore;
    }

    /**
     * @var string
     *
     * @return GetExternalTaskQueryParams
     */
    public function setTenantIdIn(string $tenantIdIn): self
    {
        $this->tenantIdIn = $tenantIdIn;

        return $this;
    }

    /**
     * @return string
     */
    public function getTenantIdIn()
    {
        return $this->tenantIdIn;
    }

    /**
     * @var string
     *
     * @return GetExternalTaskQueryParams
     */
    public function setSortOrder(string $sortOrder): self
    {
        $this->sortOrder = $sortOrder;

        return $this;
    }

    /**
     * @return string
     */
    public function getSortOrder()
    {
        return $this->sortOrder;
    }

    /**
     * @var string
     *
     * @return GetExternalTaskQueryParams
     */
    public function setTopicName(string $topicName): self
    {
        $this->topicName = $topicName;

        return $this;
    }

    /**
     * @return string
     */
    public function getTopicName()
    {
        return $this->topicName;
    }

    /**
     * @var string
     *
     * @return GetExternalTaskQueryParams
     */
    public function setSortBy(string $sortBy): self
    {
        $this->sortBy = $sortBy;

        return $this;
    }

    /**
     * @return string
     */
    public function getSortBy()
    {
        return $this->sortBy;
    }

    /**
     * @var string
     *
     * @return GetExternalTaskQueryParams
     */
    public function setNoRetriesLeft(string $noRetriesLeft): self
    {
        $this->noRetriesLeft = $noRetriesLeft;

        return $this;
    }

    /**
     * @return string
     */
    public function getNoRetriesLeft()
    {
        return $this->noRetriesLeft;
    }

    /**
     * @var string
     *
     * @return GetExternalTaskQueryParams
     */
    public function setExternalTaskId(string $externalTaskId): self
    {
        $this->externalTaskId = $externalTaskId;

        return $this;
    }

    /**
     * @return string
     */
    public function getExternalTaskId()
    {
        return $this->externalTaskId;
    }

    /**
     * @var string
     *
     * @return GetExternalTaskQueryParams
     */
    public function setLocked(string $locked): self
    {
        $this->locked = $locked;

        return $this;
    }

    /**
     * @return string
     */
    public function getLocked()
    {
        return $this->locked;
    }

    /**
     * @var string
     *
     * @return GetExternalTaskQueryParams
     */
    public function setActivityIdIn(string $activityIdIn): self
    {
        $this->activityIdIn = $activityIdIn;

        return $this;
    }

    /**
     * @return string
     */
    public function getActivityIdIn()
    {
        return $this->activityIdIn;
    }
}
