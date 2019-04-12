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
use Gen\Exception;
use Gen\Service\QueryParameters;
use Gen\Service\RequestParameters;
use PhpParser\Builder\Method;
use PhpParser\Node;
use PhpParser\BuilderFactory;
use Swagger\Object\Parameter\Query;

class ContainerAdderGenerator
{

    public function generateAdder(Container $container, ContainerChild $child) : Method
    {
        $factory = new BuilderFactory;

        // Add a setter
        return $factory->method('add' . ucfirst($child->getName()))
            ->makePublic()
            ->addParam($factory->param($child->getName())->setType($this->getVariableType($container, $child->getProperty()->getChildType())))
            ->setDocComment($this->getDocblock($container, $child)->generateDocBlock())
            ->addStmt(
                new Node\Stmt\Expression(new Node\Expr\Assign(new Node\Expr\Variable(sprintf('this->%s[]', $child->getName())), new Node\Expr\Variable($child->getName())))
            )
            ->addStmt(
                new Node\Stmt\Return_(new Node\Expr\Variable('this'))
            )
            ->setReturnType('self')
        ;
    }


    private function getVariableType(Container $container, \Gen\Entity\PropertyInterface $property)
    {
        switch (get_class($property)) {
            case QueryParameters::class:
            case RequestParameters::class:
            case Container::class:
                return sprintf(
                    '\%s\%s',
                    $container->getNamespace(),
                    $container->getClass()
                );
            case \Gen\Entity\StringProperty::class:
                return 'string';
                break;
            case \Gen\Entity\BooleanProperty::class:
                return 'bool';
                break;
            case \Gen\Entity\IntegerProperty::class:
                return 'int';
                break;
            case \Gen\Entity\ArrayProperty::class:
                return 'array';
                break;
        }
        return 'Unknown type';
    }

    private function getDocblock(Container $container, ContainerChild $child) : DocBlock
    {
        $db = new DocBlock();
        if (null !== $child->getProperty()->getDescription()) {
            $db->addComment($child->getProperty()->getDescription());
        }
        $db->addComment(sprintf('@var %s $%s', $this->getDocblockType($container, $child->getProperty()), $child->getName()));
        $db->addComment(sprintf('@return %s', $container->getClass()));
        return $db;
    }


    private function getDocblockType(Container $container, \Gen\Entity\PropertyInterface $property)
    {
        switch (get_class($property)) {
            case QueryParameters::class:
            case RequestParameters::class:
            case Container::class:
                return sprintf(
                    '\%s\%s',
                    $container->getNamespace(),
                    $container->getClass()
                );
            case \Gen\Entity\StringProperty::class:
                return 'string';
                break;
            case \Gen\Entity\BooleanProperty::class:
                return 'bool';
                break;
            case \Gen\Entity\IntegerProperty::class:
                return 'int';
                break;
            case \Gen\Entity\ArrayProperty::class:
                /* @var $property \Gen\Entity\ArrayProperty */
                $childDockblockType = $this->getDocblockType($container, $property->getChildType());
                return sprintf('%s[]', $childDockblockType);
                break;
            default:
                throw new Exception(sprintf('Unknown type %s', get_class($property)));
        }
        return 'Unknown type';
    }

}