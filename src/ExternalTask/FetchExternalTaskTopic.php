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

    /**
     * @var string
     */
    public function setTopicName(string $topicName)
    {
        $this->topicName = $topicName;
    }

    /**
     * @return string
     */
    public function getTopicName()
    {
        return $this->topicName;
    }

    /**
     * @var int
     */
    public function setLockDuration(int $lockDuration)
    {
        $this->lockDuration = $lockDuration;
    }

    /**
     * @return int
     */
    public function getLockDuration()
    {
        return $this->lockDuration;
    }

    /**
     * @var string[]
     */
    public function setVariables(array $variables)
    {
        $this->variables = $variables;
    }

    /**
     * @return string[]
     */
    public function getVariables()
    {
        return $this->variables;
    }

    /**
     * @var string[]
     */
    public function addVariables(string $variables)
    {
        $this->variables[] = $variables;
    }

    /**
     * @var bool
     */
    public function setDeserializeValues(bool $deserializeValues)
    {
        $this->deserializeValues = $deserializeValues;
    }

    /**
     * @return bool
     */
    public function getDeserializeValues()
    {
        return $this->deserializeValues;
    }
}
