<?php
/**
 * Created by PhpStorm.
 * User: fromz
 * Date: 7/04/19
 * Time: 11:49 AM
 */

namespace Gen\Entity;


class ContainerChild
{
    /**
     * @var string
     */
    private $name;

    /**
     * @var PropertyInterface
     */
    private $property;

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }

    /**
     * @return PropertyInterface
     */
    public function getProperty(): PropertyInterface
    {
        return $this->property;
    }

    /**
     * @param PropertyInterface $property
     */
    public function setProperty(PropertyInterface $property): void
    {
        $this->property = $property;
    }

}