<?php
/**
 * Created by PhpStorm.
 * User: fromz
 * Date: 7/04/19
 * Time: 10:50 AM
 */

namespace Gen\Entity;

use Gen\ClassTypeInterface;
use Gen\ClassTypeTrait;

class Container extends AbstractProperty implements PropertyInterface, ClassTypeInterface
{

    use ClassTypeTrait;

    public function getPhpPropertyType(): string
    {
        return $this->getFqn();
    }

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

}