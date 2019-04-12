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
use PhpParser\Builder\Method;
use PhpParser\BuilderFactory;
use PhpParser\Node;

class ContainerGetterGenerator
{

    public function generateGetter(Container $container, ContainerChild $child) : Method
    {
        $factory = new BuilderFactory;
        return $factory->method('get' . ucfirst($child->getName()))
            ->makePublic()
            ->setDocComment($this->getDocblock($container, $child->getProperty())->generateDocBlock())
            ->addStmt(
                new Node\Stmt\Return_(new Node\Expr\PropertyFetch(new Node\Expr\Variable('this'), $child->getName()))
            );
    }

    function getDocblock(Container $container, \Gen\Entity\PropertyInterface $property) : \Gen\DocBlock
    {
        $db = new \Gen\DocBlock();
        if (null !== $property->getDescription()) {
            $db->addComment($property->getDescription());
        }
        $db->addComment(sprintf('@return %s', $this->getDocblockType($container, $property)));
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