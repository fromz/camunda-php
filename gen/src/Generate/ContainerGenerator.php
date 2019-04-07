<?php
/**
 * Created by PhpStorm.
 * User: fromz
 * Date: 7/04/19
 * Time: 12:35 PM
 */

namespace Gen\Generate;


use Gen\Entity\Container;
use PhpParser\BuilderFactory;

class ContainerGenerator
{
    /**
     * @var Context
     */
    private $context;

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

    public function __construct(Context $context)
    {
        $this->context = $context;
        $this->containerPropertyGenerator = new ContainerPropertyGenerator($context);
        $this->containerSetterGenerator = new ContainerSetterGenerator($context);
        $this->containerGetterGenerator = new ContainerGetterGenerator($context);
    }

    public function generate($schemaName, Container $container)
    {
        // Build the code
        $factory = new BuilderFactory;
        $node = $factory->namespace($this->context->getMap()[$schemaName]['namespace']);
        $class = $factory->class($this->context->getMap()[$schemaName]['class']);

        foreach ($container->getChildren() as $child) {
            $class->addStmt($this->containerPropertyGenerator->generateProperty($child));
            $class->addStmt($this->containerSetterGenerator->generateSetter($child));
            $class->addStmt($this->containerGetterGenerator->generateGetter($child));
        }

        $node->addStmt($class);

        return $node;
    }

}