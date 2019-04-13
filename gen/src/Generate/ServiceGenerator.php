<?php
/**
 * Created by PhpStorm.
 * User: fromz
 * Date: 13/04/19
 * Time: 9:04 AM
 */

namespace Gen\Generate;


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

        $namespace->addStmt($factory->use('GuzzleHttp\RequestOptions'));

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

            // Make $path variable to make requests to
            $sprintfPath = $endpointDefinition->getPath();
            $sprintfArgs = [];
            foreach ($endpointDefinition->getPathParameters() as $paramName => $param) {
                $sprintfArgs[] = new Node\Arg($factory->var($paramName));
                $sprintfPath = str_replace(sprintf('{%s}', $paramName), '%s', $sprintfPath);
            }
            $method->addStmt(
                new Node\Stmt\Expression(
                    new Node\Expr\Assign(
                        new Node\Expr\Variable('path'),
                        new Node\Expr\FuncCall(new Node\Name('sprintf'), array_merge([
                            new Node\Scalar\String_($sprintfPath),
                        ], $sprintfArgs))
                    )
                )
            );

            $tryStatements = [];
            switch ($endpointDefinition->getHttpMethod()) {
                case 'get':
                    $guzzleRequestOptions = [];

                    // Add query params to request if there's a reason to do so
                    if ($endpointDefinition->hasQueryParameters()) {
                        $guzzleRequestOptions[] = new Node\Expr\ArrayItem(
                            new Node\Expr\Array_(),
                            new Node\Expr\ClassConstFetch(new Node\Name('RequestOptions'), 'QUERY')
                        );
                    }

                    $tryStatements[] = new Node\Stmt\Expression(
                        new Node\Expr\Assign(
                            new Node\Expr\Variable('response'),
                            $factory->methodCall(new Node\Expr\Variable('this->guzzle'), 'request', [
                                new Node\Scalar\String_('GET'),
                                new Node\Expr\Variable('path'),
                                new Node\Expr\Array_($guzzleRequestOptions, [
                                    'kind' => Node\Expr\Array_::KIND_SHORT,
                                ]),
                            ])
                        )
                    );
                    break;
                case 'post':
                    $tryStatements[] = new Node\Stmt\Expression($factory->methodCall(new Node\Expr\Variable('this->guzzle'), 'post', [
                        new Node\Expr\Variable('path'),
                    ]));
                    break;
            }

            $method->addStmt(
                new Node\Stmt\TryCatch($tryStatements, [
                    new Node\Stmt\Catch_([
                        new Node\Name('\GuzzleHttp\Exception\GuzzleException'),
                    ], new Node\Expr\Variable('e')),
                    new Node\Stmt\Catch_([
                        new Node\Name('\Exception'),
                    ], new Node\Expr\Variable('e')),
                ])
            );
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