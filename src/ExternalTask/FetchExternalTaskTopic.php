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
     *
     * @return FetchExternalTaskTopic
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
     * @var int
     *
     * @return FetchExternalTaskTopic
     */
    public function setLockDuration(int $lockDuration): self
    {
        $this->lockDuration = $lockDuration;

        return $this;
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
     *
     * @return FetchExternalTaskTopic
     */
    public function setVariables(array $variables): self
    {
        $this->variables = $variables;

        return $this;
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
     *
     * @return FetchExternalTaskTopic
     */
    public function addVariables(string $variables): self
    {
        $this->variables[] = $variables;

        return $this;
    }

    /**
     * @var bool
     *
     * @return FetchExternalTaskTopic
     */
    public function setDeserializeValues(bool $deserializeValues): self
    {
        $this->deserializeValues = $deserializeValues;

        return $this;
    }

    /**
     * @return bool
     */
    public function getDeserializeValues()
    {
        return $this->deserializeValues;
    }
}
