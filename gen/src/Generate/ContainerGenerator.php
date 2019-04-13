<?php
/**
 * Created by PhpStorm.
 * User: fromz
 * Date: 7/04/19
 * Time: 12:35 PM
 */

namespace Gen\Generate;


use Gen\Entity\ArrayProperty;
use Gen\Entity\Container;
use PhpParser\Builder\Namespace_;
use PhpParser\BuilderFactory;
use PhpParser\Node;

class ContainerGenerator
{

    private $classGenerator;

    /**
     * @var ContainerPropertyGenerator
     */
    private $containerPropertyGenerator;

    /**
     * @var ContainerSetterGenerator
     */
    private $containerSetterGenerator;

    /**
     * @var ContainerGetterGenerator
     */
    private $containerGetterGenerator;

    /**
     * @var ContainerAdderGenerator
     */
    private $containerAdderGenerator;

    public function __construct()
    {
        $this->classGenerator = new ClassGenerator();
        $this->containerPropertyGenerator = new ContainerPropertyGenerator();
        $this->containerSetterGenerator = new ContainerSetterGenerator();
        $this->containerGetterGenerator = new ContainerGetterGenerator();
        $this->containerAdderGenerator = new ContainerAdderGenerator();
    }

    public function generate(Container $container) : Namespace_
    {
        // Build the code
        $factory = new BuilderFactory;
        $namespace = $factory->namespace($container->getNamespaceWithoutLeadingSlash());
        $this->classGenerator->generate($container);
        $class = $factory->class($container->getClass());

        foreach ($container->getChildren() as $child) {
            $class->addStmt($this->containerPropertyGenerator->generateProperty($container, $child));
            $class->addStmt($this->containerSetterGenerator->generateSetter($container, $child));
            $class->addStmt($this->containerGetterGenerator->generateGetter($container, $child));
            if ($child->getProperty() instanceof ArrayProperty) {
                $class->addStmt($this->containerAdderGenerator->generateAdder($container, $child));
            }
        }

        // jsonSerialize method
        $factory = new BuilderFactory;
        $class->implement('\JsonSerializable');
        $ifAssignmentStatments = [];
        foreach ($container->getChildren() as $child) {
            $if = new Node\Stmt\If_(new Node\Expr\BinaryOp\NotIdentical(
                new Node\Expr\PropertyFetch(new Node\Expr\Variable('this'), $child->getName()),
                new Node\Expr\ConstFetch(new Node\Name('null'))
            ), [
                'stmts' => [
                    new Node\Stmt\Expression(new Node\Expr\Assign(
                        new Node\Expr\ArrayDimFetch(
                            new Node\Expr\Variable('json'),
                            new Node\Scalar\String_($child->getName())
                        ),
                        new Node\Expr\PropertyFetch(
                            new Node\Expr\Variable('this'),
                            new Node\Identifier($child->getName())
                        )
                    ))
                ]
            ]);
            $ifAssignmentStatments[] = $if;
        }
        $method = $factory->method('jsonSerialize')
            ->makePublic()
            ->addStmt(new Node\Expr\Assign(
                new Node\Expr\Variable('json'),
                new Node\Expr\Array_()
            ))
            ->addStmts($ifAssignmentStatments)
            ->addStmt(
                new Node\Stmt\Return_(new Node\Expr\Variable('json'))
            );
        $class->addStmt($method);

        $namespace->addStmt($class);

        return $namespace;
    }

}