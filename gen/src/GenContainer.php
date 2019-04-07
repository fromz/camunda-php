<?php
/**
 * Created by PhpStorm.
 * User: fromz
 * Date: 7/04/19
 * Time: 12:35 PM
 */

namespace Gen;


use Gen\Entity\Container;
use PhpParser\BuilderFactory;
use PhpParser\PrettyPrinter;
use PhpParser\Node;


class GenContainer
{
    private $map;

    public function __construct(array $map)
    {
        $this->map = $map;
    }

    public function generate($schemaName, Container $container)
    {
        // Build the code
        $factory = new BuilderFactory;
        $node = $factory->namespace($this->map[$schemaName]['namespace']);
        $class = $factory->class($this->map[$schemaName]['class']);

        foreach ($container->getChildren() as $child) {
            // Add property
            $classProperty = $factory
                ->property($child->getName())
                ->makePrivate();
            $containerProperty = $child->getProperty();
            $db = $this->getDocblock($containerProperty);
            $classProperty->setDocComment($db->generateDocBlock());
            switch (get_class($containerProperty)) {
                case \Gen\Entity\ArrayProperty::class:
                    $classProperty->setDefault([]);
                    break;
            }
            $class->addStmt($classProperty);

            // Add a setter
            $class->addStmt($factory->method('set' . ucfirst($child->getName()))
                ->makePublic()
                ->addParam($factory->param($child->getName())->setType($this->getVariableType($child->getProperty())))
                ->addStmt(
                    new Node\Stmt\Expression(new Node\Expr\Assign(new Node\Expr\Variable('this->' . $child->getName()), new Node\Expr\Variable($child->getName())))
                )
            );

            // Add a getter
            $class->addStmt($factory->method('get' . ucfirst($child->getName()))
                ->makePublic()
                ->addStmt(
                    new Node\Stmt\Return_(new Node\Expr\PropertyFetch(new Node\Expr\Variable('this'), $child->getName()))
                )
            );
        }

        $node->addStmt($class);

        return $node;
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

    function getVariableType(\Gen\Entity\PropertyInterface $property)
    {
        switch (get_class($property)) {
            case \Gen\Entity\Container::class:
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
                    $this->map[$property->getSchemaReference()]['namespace'],
                    $this->map[$property->getSchemaReference()]['class']
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