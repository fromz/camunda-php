<?php
/**
 * Created by PhpStorm.
 * User: fromz
 * Date: 7/04/19
 * Time: 1:46 PM
 */

namespace Gen\Generate;


use Gen\Entity\ContainerChild;
use PhpParser\Builder\Method;
use PhpParser\Node;
use PhpParser\BuilderFactory;

class ContainerSetterGenerator
{

    /**
     * @var Context
     */
    private $context;

    public function __construct(Context $context)
    {
        $this->context = $context;
    }

    public function generateSetter(ContainerChild $child) : Method
    {
        $factory = new BuilderFactory;

        // Add a setter
        return $factory->method('set' . ucfirst($child->getName()))
            ->makePublic()
            ->addParam($factory->param($child->getName())->setType($this->getVariableType($child->getProperty())))
            ->addStmt(
                new Node\Stmt\Expression(new Node\Expr\Assign(new Node\Expr\Variable('this->' . $child->getName()), new Node\Expr\Variable($child->getName())))
            );
    }


    function getVariableType(\Gen\Entity\PropertyInterface $property)
    {
        switch (get_class($property)) {
            case \Gen\Entity\Container::class:
                /* @var $property \Gen\Entity\Container */
                return sprintf(
                    '%s\%s',
                    $this->map[$property->getSchemaReference()]['namespace'],
                    $this->map[$property->getSchemaReference()]['class']
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

    function getDocblock(\Gen\Entity\PropertyInterface $property) : \Gen\DocBlock
    {
        $db = new \Gen\DocBlock();
        if (null !== $property->getDescription()) {
            $db->addComment($property->getDescription());
        }
        $db->addComment(sprintf('@var %s', $this->getDocblockType($property)));
        return $db;
    }


    function getDocblockType(\Gen\Entity\PropertyInterface $property)
    {
        $nullable = '';
        if (true === $property->getNullable()) {
            $nullable = '|null';
        }
        switch (get_class($property)) {
            case \Gen\Entity\Container::class:
                return sprintf(
                    '%s\%s',
                    $this->context->getMap()[$property->getSchemaReference()]['namespace'],
                    $this->context->getMap()[$property->getSchemaReference()]['class']
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
                $childDockblockType = $this->getDocblockType($property->getChildType());
                return sprintf('%s[]', $childDockblockType);
                break;
        }
        return 'Unknown type';
    }

}