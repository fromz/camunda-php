<?php
/**
 * Created by PhpStorm.
 * User: fromz
 * Date: 13/04/19
 * Time: 9:04 AM
 */

namespace Gen\Generate;


use Gen\Service\ResponseException;
use PhpParser\Builder\Namespace_;
use PhpParser\BuilderFactory;

class ExceptionGenerator
{
    public function generate(ResponseException $responseException) : Namespace_
    {
        $classGenerator = new ClassGenerator();
        // Build the code
        $factory = new BuilderFactory;
        $namespace = $factory->namespace($responseException->getNamespace());
        $classGenerator->generate($responseException);
        $class = $factory->class($responseException->getClass());
        $namespace->addStmt($class);
        return $namespace;
    }
}