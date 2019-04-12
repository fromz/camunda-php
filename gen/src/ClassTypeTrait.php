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
     * @var ClassTypeInterface
     */
    private $extends;

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

    public function getFqn() : string
    {
        return sprintf('%s\%s', $this->getNamespace(), $this->getClass());
    }

    /**
     * @return ClassTypeInterface
     */
    public function getExtends(): ClassTypeInterface
    {
        return $this->extends;
    }

    /**
     * @param ClassTypeInterface $extends
     * @return ClassTypeTrait
     */
    public function setExtends(ClassTypeInterface $extends): self
    {
        $this->extends = $extends;
        return $this;
    }

    public function hasExtends() : bool
    {
        return $this->extends !== null;
    }

}