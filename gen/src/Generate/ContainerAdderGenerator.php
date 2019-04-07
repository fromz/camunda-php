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
use PhpParser\Node;
use PhpParser\BuilderFactory;

class ContainerAdderGenerator
{

    /**
     * @var Context
     */
    private $context;

    public function __construct(Context $context)
    {
        $this->context = $context;
    }

    public function generateAdder(Container $container, ContainerChild $child) : Method
    {
        $factory = new BuilderFactory;

        // Add a setter
        return $factory->method('add' . ucfirst($child->getName()))
            ->makePublic()
            ->addParam($factory->param($child->getName())->setType($this->getVariableType($child->getProperty()->getChildType())))
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


    private function getVariableType(\Gen\Entity\PropertyInterface $property)
    {
        switch (get_class($property)) {
            case \Gen\Entity\Container::class:
                /* @var $property \Gen\Entity\Container */
                return sprintf(
                    '\%s\%s',
                    $this->context->getMap()[$property->getSchemaReference()]['namespace'],
                    $this->context->getMap()[$property->getSchemaReference()]['class']
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

    private function getDocblock(Container $container, ContainerChild $child) : \Gen\DocBlock
    {
        $db = new \Gen\DocBlock();
        if (null !== $child->getProperty()->getDescription()) {
            $db->addComment($child->getProperty()->getDescription());
        }
        $db->addComment(sprintf('@var %s $%s', $this->getDocblockType($child->getProperty()), $child->getName()));
        $db->addComment(sprintf('@return %s', $container->getClass()));
        return $db;
    }


    private function getDocblockType(\Gen\Entity\PropertyInterface $property)
    {
        switch (get_class($property)) {
            case \Gen\Entity\Container::class:
                return sprintf(
                    '\%s\%s',
                    $this->context->getMap()[$property->getSchemaReference()]['namespace'],
                    $this->context->getMap()[$property->getSchemaReference()]['class']
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
                $childDockblockType = $this->getDocblockType($property->getChildType());
                return sprintf('%s[]', $childDockblockType);
                break;
        }
        return 'Unknown type';
    }

}