<?php
/**
 * Created by PhpStorm.
 * User: fromz
 * Date: 13/04/19
 * Time: 5:34 AM
 */

namespace Gen\SwaggerAdapter;

use Gen\Exception;
use Gen\Service\EndpointDefinition;
use Gen\Service\QueryParameters;
use Gen\Service\ResponseContent;

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
        $endpointDefinition->setPath($path);
        $op = $this->getOperation($path, $httpMethod);
        if ($config->hasQueryParamAs()) {
            $endpointDefinition->setQueryParameters($this->applyPathParametersToQueryParameters(
                $config->getQueryParamsAs(),
                $path,
                $httpMethod
            ));
        }

        // Add URL Parameters
        foreach ($op->getParameters() as $param) {
            /* @var $param \Swagger\Object\Parameter */
            if ('path' !== $param->getIn()) {
                continue;
            }
            $schemaConverter = new \Gen\SwaggerAdapter\SchemaConverter($this->document, $config->getRequestSchemaReferences());
            $endpointDefinition->addPathParameter($param->getName(), $schemaConverter->parameterToProperty($param));

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

        foreach ($config->getResponseCodesAs() as $responseCode => $responseType) {
            $responses = $op->getResponses();
            /* @var $responses \Swagger\Object\Responses */
            if ($responseType instanceof ResponseContent) {
                $schemaConverter = new \Gen\SwaggerAdapter\SchemaConverter($this->document, $config->getRequestSchemaReferences());
                $r = $responses->getItem($responseCode);
                /* @var $r \Swagger\Object\Response */
                $schema = $r->getSchema();
                /* @var $schema \Swagger\Object\Schema */
                switch ($schema->getType()) {
                    case 'array':
                        $items = $schema->getItems();
                        /* @var $items \Swagger\Object\Items */
                        $schemaConverter->applySchemaPropertiesToResponseContent($responseType, $items->getDocument()->{'$ref'});
                        break;
                    default:
                        throw new Exception("dont know how to map this type %s", $schema->getType());
                }
            }
            $endpointDefinition->addResponse($responseCode, $responseType);
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