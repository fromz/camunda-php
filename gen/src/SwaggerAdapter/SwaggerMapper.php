<?php
/**
 * Created by PhpStorm.
 * User: fromz
 * Date: 13/04/19
 * Time: 5:34 AM
 */

namespace Gen\SwaggerAdapter;

use Gen\Service\EndpointDefinition;
use Gen\Service\QueryParameters;

class SwaggerMapper
{
    /**
     * @var \Swagger\Document
     */
    private $document;

    public function __construct(\Swagger\Document $document)
    {
        $this->document = $document;
    }

    public function pathToEndpoint(string $path, string $httpMethod, EndpointConfig $config) : EndpointDefinition
    {
        $endpointDefinition = new EndpointDefinition();
        $endpointDefinition->setHttpMethod($httpMethod);
        $op = $this->getOperation($path, $httpMethod);
        if ($config->hasQueryParamAs()) {
            $endpointDefinition->setQueryParameters($this->applyPathParametersToQueryParameters(
                $config->getQueryParamsAs(),
                $path,
                $httpMethod
            ));
        }

        if ($config->hasRequestParametersAs()) {
            // find the only operation parameter which is defined in the bodoy
            foreach ($op->getParameters() as $param) {
                /* @var $param \Swagger\Object\Parameter */
                if ('body' !== $param->getIn()) {
                    continue;
                }
                $schemaConverter = new \Gen\SwaggerAdapter\SchemaConverter($this->document, $config->getRequestSchemaReferences());
                $requestParameters = $config->getRequestParametersAs();
                $schema = $param->getDocumentProperty('schema');
                $schemaConverter->applySchemaPropertiesToRequestParameters($requestParameters, $schema->{'$ref'});
                $endpointDefinition->setRequestParameters($requestParameters);
            }
        }

        foreach ($config->getRequestSchemaReferences() as $schemaReference) {
            $endpointDefinition->addReferencedContainer($schemaReference->getContainer());
        }

        return $endpointDefinition;
    }

    private function getOperation(string $path, string $httpMethod) : \Swagger\Object\Operation
    {
        $paths = $this->document->getPaths();
        /* @var $paths \Swagger\Object\Paths */
        $spath = $paths->getPath($path);
        /* @var $path \Swagger\Object\PathItem */
        switch ($httpMethod) {
            case 'get':
                return $spath->getGet();
            case 'post':
                return $spath->getPost();
        }
    }

    public function applyPathParametersToQueryParameters(QueryParameters $queryParameters, string $path, string $httpMethod) : QueryParameters
    {
        $operation = $this->getOperation($path, $httpMethod);
        foreach ($operation->getParameters() as $param) {
            /* @var $param \Swagger\Object\Parameter */
            if ('query' !== $param->getIn()) {
                continue;
            }
            switch ($param->getDocument()->type) {
                case 'integer':
                    $classProperty = new \Gen\Entity\IntegerProperty();
                    $queryParameters->addChild($param->getName(), $classProperty);
                    break;
                case 'string':
                    $classProperty = new \Gen\Entity\StringProperty();
                    $queryParameters->addChild($param->getName(), $classProperty);
                    break;
                case 'boolean':
                    $classProperty = new \Gen\Entity\BooleanProperty();
                    $queryParameters->addChild($param->getName(), $classProperty);
                    break;
                default:
                    throw new \Exception(sprintf('Unsupported parameter type %s', $param->getDocument()->type));
            }
        }

        return $queryParameters;
    }

}