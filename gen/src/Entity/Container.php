<?php
/**
 * Created by PhpStorm.
 * User: fromz
 * Date: 7/04/19
 * Time: 10:50 AM
 */

namespace Gen\Entity;

class Container extends AbstractProperty implements PropertyInterface
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
     * @var string
     */
    private $schemaReference;

    /**
     * @var ContainerChild[]
     */
    private $children = [];

    /**
     * @return ContainerChild[]
     */
    public function getChildren() : array
    {
        return $this->children;
    }

    /**
     * @param string $name
     * @param PropertyInterface $property
     */
    public function addChild(string $name, PropertyInterface $property)
    {
        $child = new ContainerChild();
        $child->setProperty($property);
        $child->setName($name);
        $this->children[] = $child;
    }

    /**
     * @return string
     */
    public function getSchemaReference(): string
    {
        return $this->schemaReference;
    }

    /**
     * @param string $schemaReference
     */
    public function setSchemaReference(string $schemaReference): void
    {
        $this->schemaReference = $schemaReference;
    }

    /**
     * @return string
     */
    public function getNamespace(): string
    {
        return $this->namespace;
    }

    /**
     * @param string $namespace
     * @return Container
     */
    public function setNamespace(string $namespace): Container
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
     * @return Container
     */
    public function setClass(string $class): Container
    {
        $this->class = $class;
        return $this;
    }

}