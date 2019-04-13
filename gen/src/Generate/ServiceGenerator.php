<?php
/**
 * Created by PhpStorm.
 * User: fromz
 * Date: 13/04/19
 * Time: 9:04 AM
 */

namespace Gen\Generate;


use Gen\Service\ResponseException;
use Gen\Service\Service;
use PhpParser\Builder\Namespace_;
use PhpParser\BuilderFactory;
use PhpParser\Node;

class ServiceGenerator
{
    public function generate(Service $service) : Namespace_
    {
        $classGenerator = new ClassGenerator();
        // Build the code
        $factory = new BuilderFactory;
        $namespace = $factory->namespace($service->getNamespaceWithoutLeadingSlash());
        $namespace->addStmt($factory->use('GuzzleHttp\Client'));

        $class = $classGenerator->generate($service);

        $db = new DocBlock();
        $db->addComment('@var Client');
        $classProperty = $factory
            ->property('guzzle')
            ->makePrivate()
            ->setDocComment($db->generateDocBlock())
        ;
        $class->addStmt($classProperty);

        $method = $factory->method('__construct')
            ->makePublic()
            ->addParam($factory->param('guzzle')->setType('Client'))
            ->addStmt(
                new Node\Stmt\Expression(new Node\Expr\Assign(
                    new Node\Expr\Variable('this->guzzle'),
                    new Node\Expr\Variable('guzzle')
                ))
            )
        ;
        $class->addStmt($method);

        foreach ($service->getEndpointDefinitions() as $methodName => $endpointDefinition) {

            $db = new DocBlock();

            $method = $factory->method($methodName)->makePublic();
            foreach ($endpointDefinition->getPathParameters() as $paramName => $param) {
                $method->addParam($factory->param($paramName)->setType($param->getPhpPropertyType()));
            }
            if (true === $endpointDefinition->hasRequestParameters()) {
                $method->addParam($factory->param('requestParameters')->setType($endpointDefinition->getRequestParameters()->getPhpPropertyType()));
            }
            if (true === $endpointDefinition->hasQueryParameters()) {
                $method->addParam($factory->param('queryParameters')->setType($endpointDefinition->getQueryParameters()->getPhpPropertyType()));
            }
            foreach ($endpointDefinition->getResponses() as $response) {
                if ($response->isException()) {
                    $db->addComment(sprintf('@throws %s', $response->getFqn()));
                }
                if ($response->isReturnType()) {
                    $method->setReturnType($response->getFqn());
                    $db->addComment(sprintf('@returns %s', $response->getFqn()));
                }
            }

            $db = $db->generateDocBlock();
            if (null !== $db) {
                $method->setDocComment($db);
            }

            $class->addStmt($method);

        }
        $namespace->addStmt($class);
        return $namespace;
    }
}