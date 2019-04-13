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

    /**
     * @var ClassGenerator
     */
    private $classGenerator;

    /**
     * @var ContainerToArrayGenerator
     */
    private $toArrayGenerator;

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

    /**
     * @var ContainerArrayFactoryGenerator
     */
    private $arrayFactoryGenerator;

    public function __construct()
    {
        $this->classGenerator = new ClassGenerator();
        $this->containerPropertyGenerator = new ContainerPropertyGenerator();
        $this->containerSetterGenerator = new ContainerSetterGenerator();
        $this->containerGetterGenerator = new ContainerGetterGenerator();
        $this->containerAdderGenerator = new ContainerAdderGenerator();
        $this->toArrayGenerator = new ContainerToArrayGenerator();
        $this->arrayFactoryGenerator = new ContainerArrayFactoryGenerator();
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
        $class->implement('\JsonSerializable');
        $class->addStmt($this->toArrayGenerator->generateToArrayMethod($container));
        $jsonSerializeMethod = $factory->method('jsonSerialize')
            ->makePublic()
            ->addStmt(
                new Node\Stmt\Return_(new Node\Expr\MethodCall(new Node\Expr\Variable('this'), 'toArray'))
            );
        $class->addStmt($jsonSerializeMethod);

        // array factory
        $class->addStmt($this->arrayFactoryGenerator->generateArrayFactory($container));

        $namespace->addStmt($class);

        return $namespace;
    }

}