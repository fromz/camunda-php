<?php
/**
 * Created by PhpStorm.
 * User: fromz
 * Date: 13/04/19
 * Time: 4:37 AM
 */

namespace Gen;


trait ClassTypeTrait
{
    /**
     * @var string
     */
    private $namespace;

    /**
     * @var string
     */
    private $class;

    /**
     * @return string
     */
    public function getNamespace(): string
    {
        return $this->namespace;
    }

    /**
     * @param string $namespace
     * @return self
     */
    public function setNamespace(string $namespace): self
    {
        $this->namespace = $namespace;
        return $this;
    }

    /**
     * @return string
     */
    public function getClass(): string
    {
        return $this->class;
    }

    /**
     * @param string $class
     * @return self
     */
    public function setClass(string $class): self
    {
        $this->class = $class;
        return $this;
    }

}