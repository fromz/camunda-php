<?php
/**
 * Created by PhpStorm.
 * User: fromz
 * Date: 7/04/19
 * Time: 1:46 PM
 */

namespace Gen\Generate;


use Gen\Entity\Container;
use Gen\Entity\ContainerChild;
use PhpParser\Builder\Property;
use PhpParser\BuilderFactory;

class ContainerPropertyGenerator
{

    public function generateProperty(Container $container, ContainerChild $child) : Property
    {
        $factory = new BuilderFactory;
        $classProperty = $factory
            ->property($child->getName())
            ->makePrivate();
        $containerProperty = $child->getProperty();
        $db = $this->getDocblock($container, $containerProperty);
        $classProperty->setDocComment($db->generateDocBlock());
        switch (get_class($containerProperty)) {
            case \Gen\Entity\ArrayProperty::class:
                $classProperty->setDefault([]);
                break;
        }
        return $classProperty;
    }

    function getDocblock(Container $container, \Gen\Entity\PropertyInterface $property) : \Gen\DocBlock
    {
        $db = new \Gen\DocBlock();
        if (null !== $property->getDescription()) {
            $db->addComment($property->getDescription());
        }
        $db->addComment(sprintf('@var %s', $this->getDocblockType($container, $property)));
        return $db;
    }


    function getDocblockType(Container $container, \Gen\Entity\PropertyInterface $property)
    {
        $nullable = '';
        if (true === $property->getNullable()) {
            $nullable = '|null';
        }
        switch (get_class($property)) {
            case \Gen\Entity\Container::class:
                return sprintf(
                    '\%s\%s',
                    $container->getNamespace(),
                    $container->getClass()
                );
            case \Gen\Entity\StringProperty::class:
                return 'string' . $nullable;
                break;
            case \Gen\Entity\BooleanProperty::class:
                return 'bool' . $nullable;
                break;
            case \Gen\Entity\IntegerProperty::class:
                return 'int' . $nullable;
                break;
            case \Gen\Entity\ArrayProperty::class:
                /* @var $property \Gen\Entity\ArrayProperty */
                $childDockblockType = $this->getDocblockType($container, $property->getChildType());
                return sprintf('%s[]', $childDockblockType);
                break;
        }
        return 'Unknown type';
    }

}