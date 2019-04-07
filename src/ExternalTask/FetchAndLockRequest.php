<?php

namespace Camunda\ExternalTask;

class FetchAndLockRequest
{
    /**
     * Mandatory. The maximum number of tasks to return.
     * @var int
     */
    private $maxTasks;
    /**
     * Mandatory. The id of the worker on which behalf tasks are fetched. The returned tasks are locked for that worker and can only be completed when providing the same worker id.
     * @var string
     */
    private $workerId;
    /**
     * @var bool
     */
    private $usePriority;
    /**
     * A JSON array of topic objects for which external tasks should be fetched. The returned tasks may be arbitrarily distributed among these topics. Each topic object has the following properties: Name Description topicName Mandatory. The topic's name. lockDuration Mandatory. The duration to lock the external tasks for in milliseconds. variables A JSON array of String values that represent variable names. For each result task belonging to this topic, the given variables are returned as well if they are accessible from the external task's execution. If not provided - all variables will be fetched. deserializeValues Determines whether serializable variable values (typically variables that store custom Java objects) should be deserialized on server side (default false).
     * @var \Camunda\ExternalTask\FetchExternalTaskTopic[]
     */
    private $topics = array();
    public function setMaxTasks(int $maxTasks)
    {
        $this->maxTasks = $maxTasks;
    }
    public function getMaxTasks()
    {
        return $this->maxTasks;
    }
    public function setWorkerId(string $workerId)
    {
        $this->workerId = $workerId;
    }
    public function getWorkerId()
    {
        return $this->workerId;
    }
    public function setUsePriority(bool $usePriority)
    {
        $this->usePriority = $usePriority;
    }
    public function getUsePriority()
    {
        return $this->usePriority;
    }
    public function setTopics(array $topics)
    {
        $this->topics = $topics;
    }
    public function getTopics()
    {
        return $this->topics;
    }
}
