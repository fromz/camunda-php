<?php
/**
 * Created by PhpStorm.
 * User: fromz
 * Date: 7/04/19
 * Time: 12:35 PM
 */

namespace Gen\Generate;


use Gen\ClassTypeInterface;
use PhpParser\Builder\Class_;
use PhpParser\BuilderFactory;

class ClassGenerator
{
    public function generate(ClassTypeInterface $classType) : Class_
    {
        // Build the code
        $factory = new BuilderFactory;
        $class = $factory->class($classType->getClass());
        if ($classType->hasExtends()) {
            $class->extend($classType->getExtends()->getFqn());
        }
        return $class;
    }
}