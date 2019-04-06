<?php
/**
 * Created by PhpStorm.
 * User: kushalhalder
 * Date: 2019-01-22
 * Time: 18:01
 */

namespace Camunda\ExternalTask;

class FetchAndLockRequest
{

    /**
     * The id of the worker on which behalf tasks are fetched. The returned
     * tasks are locked for that worker and can only be completed when
     * providing the same worker id.
     * @var string
     */
    protected $workerId;

    /**
     * The maximum number of tasks to return.
     * @var int
     */
    protected $maxTasks;

    /**
     * A boolean value, which indicates whether the task should be fetched
     * based on its priority or arbitrarily.
     * @var bool
     */
    protected $usePriority = false;

    /**
     * The Long Polling timeout in milliseconds.
     * Note: The value cannot be set larger than 1.800.000 milliseconds (corresponds to 30 minutes).
     *
     * @var int|null
     */
    protected $asyncResponseTimeout;

    /**
     * A JSON array of topic objects for which external tasks should be
     * fetched. The returned tasks may be arbitrarily distributed among
     * these topics.
     *
     * @var FetchAndLockRequestTopic[]
     */
    protected $topics = [];

    /**
     * @return string
     */
    public function getWorkerId(): string
    {
        return $this->workerId;
    }

    /**
     * @param string $workerId
     * @return FetchAndLockRequest
     */
    public function setWorkerId(string $workerId): FetchAndLockRequest
    {
        $this->workerId = $workerId;
        return $this;
    }

    /**
     * @return int
     */
    public function getMaxTasks(): int
    {
        return $this->maxTasks;
    }

    /**
     * @param int $maxTasks
     * @return FetchAndLockRequest
     */
    public function setMaxTasks(int $maxTasks): FetchAndLockRequest
    {
        $this->maxTasks = $maxTasks;
        return $this;
    }

    /**
     * @return bool
     */
    public function isUsePriority(): bool
    {
        return $this->usePriority;
    }

    /**
     * @param bool $usePriority
     * @return FetchAndLockRequest
     */
    public function setUsePriority(bool $usePriority): FetchAndLockRequest
    {
        $this->usePriority = $usePriority;
        return $this;
    }

    /**
     * @return int|null
     */
    public function getAsyncResponseTimeout(): ?int
    {
        return $this->asyncResponseTimeout;
    }

    /**
     * @param int|null $asyncResponseTimeout
     * @return FetchAndLockRequest
     */
    public function setAsyncResponseTimeout(?int $asyncResponseTimeout): FetchAndLockRequest
    {
        $this->asyncResponseTimeout = $asyncResponseTimeout;
        return $this;
    }

    /**
     * @return FetchAndLockRequestTopic[]
     */
    public function getTopics(): array
    {
        return $this->topics;
    }

    /**
     * @param FetchAndLockRequestTopic[] $topics
     * @return FetchAndLockRequest
     */
    public function setTopics(array $topics): FetchAndLockRequest
    {
        $this->topics = $topics;
        return $this;
    }


    public function addTopic(FetchAndLockRequestTopic $topic)
    {
        $this->topics[] = $topic;
    }

}
