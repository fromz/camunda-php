<?php

namespace Camunda\ExternalTask;

class FetchExternalTaskTopic
{
    /**
     * @var string
     */
    private $topicName;
    /**
     * @var int
     */
    private $lockDuration;
    /**
     * @var string[]
     */
    private $variables = array();
    /**
     * @var bool
     */
    private $deserializeValues;
    public function setTopicName(string $topicName)
    {
        $this->topicName = $topicName;
    }
    public function getTopicName()
    {
        return $this->topicName;
    }
    public function setLockDuration(int $lockDuration)
    {
        $this->lockDuration = $lockDuration;
    }
    public function getLockDuration()
    {
        return $this->lockDuration;
    }
    public function setVariables(array $variables)
    {
        $this->variables = $variables;
    }
    public function getVariables()
    {
        return $this->variables;
    }
    public function setDeserializeValues(bool $deserializeValues)
    {
        $this->deserializeValues = $deserializeValues;
    }
    public function getDeserializeValues()
    {
        return $this->deserializeValues;
    }
}
