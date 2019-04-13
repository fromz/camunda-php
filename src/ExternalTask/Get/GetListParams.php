<?php

namespace Camunda\ExternalTask\Get;

class GetListParams implements \JsonSerializable
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
     * @return GetListParams
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
     * @return GetListParams
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
     * @return GetListParams
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
     * @return GetListParams
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
     * @return GetListParams
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
     * @return GetListParams
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
     * @return GetListParams
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
     * @return GetListParams
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
     * @return GetListParams
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
     * @return GetListParams
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
     * @return GetListParams
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
     * @return GetListParams
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
     * @return GetListParams
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
     * @return GetListParams
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
     * @return GetListParams
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
     * @return GetListParams
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
     * @return GetListParams
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
     * @return GetListParams
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
     * @return GetListParams
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
     * @return GetListParams
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
     * @return GetListParams
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
     * @return GetListParams
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
     * @return GetListParams
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

    public function jsonSerialize()
    {
        $json = array();
        if (null !== $this->firstResult) {
            $json['firstResult'] = $this->firstResult;
        }
        if (null !== $this->maxResults) {
            $json['maxResults'] = $this->maxResults;
        }
        if (null !== $this->processInstanceId) {
            $json['processInstanceId'] = $this->processInstanceId;
        }
        if (null !== $this->processDefinitionId) {
            $json['processDefinitionId'] = $this->processDefinitionId;
        }
        if (null !== $this->workerId) {
            $json['workerId'] = $this->workerId;
        }
        if (null !== $this->withRetriesLeft) {
            $json['withRetriesLeft'] = $this->withRetriesLeft;
        }
        if (null !== $this->notLocked) {
            $json['notLocked'] = $this->notLocked;
        }
        if (null !== $this->lockExpirationAfter) {
            $json['lockExpirationAfter'] = $this->lockExpirationAfter;
        }
        if (null !== $this->active) {
            $json['active'] = $this->active;
        }
        if (null !== $this->suspended) {
            $json['suspended'] = $this->suspended;
        }
        if (null !== $this->activityId) {
            $json['activityId'] = $this->activityId;
        }
        if (null !== $this->executionId) {
            $json['executionId'] = $this->executionId;
        }
        if (null !== $this->priorityLowerThanOrEquals) {
            $json['priorityLowerThanOrEquals'] = $this->priorityLowerThanOrEquals;
        }
        if (null !== $this->priorityHigherThanOrEquals) {
            $json['priorityHigherThanOrEquals'] = $this->priorityHigherThanOrEquals;
        }
        if (null !== $this->lockExpirationBefore) {
            $json['lockExpirationBefore'] = $this->lockExpirationBefore;
        }
        if (null !== $this->tenantIdIn) {
            $json['tenantIdIn'] = $this->tenantIdIn;
        }
        if (null !== $this->sortOrder) {
            $json['sortOrder'] = $this->sortOrder;
        }
        if (null !== $this->topicName) {
            $json['topicName'] = $this->topicName;
        }
        if (null !== $this->sortBy) {
            $json['sortBy'] = $this->sortBy;
        }
        if (null !== $this->noRetriesLeft) {
            $json['noRetriesLeft'] = $this->noRetriesLeft;
        }
        if (null !== $this->externalTaskId) {
            $json['externalTaskId'] = $this->externalTaskId;
        }
        if (null !== $this->locked) {
            $json['locked'] = $this->locked;
        }
        if (null !== $this->activityIdIn) {
            $json['activityIdIn'] = $this->activityIdIn;
        }

        return $json;
    }
}
