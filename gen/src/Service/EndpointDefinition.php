<?php
/**
 * Created by PhpStorm.
 * User: fromz
 * Date: 12/04/19
 * Time: 3:39 PM
 */

namespace Gen\Service;


use Gen\Entity\Container;
use Gen\Entity\PropertyInterface;
use Gen\SwaggerAdapter\EndpointConfig;

class EndpointDefinition
{
    /**
     * @var QueryParameters
     */
    private $queryParameters;

    /**
     * @var RequestParameters
     */
    private $requestParameters;

    /**
     * @var PropertyInterface[]
     */
    private $pathParameters;

    /**
     * @var array
     */
    private $responseCodes;

    /**
     * @var string
     */
    private $path;

    /**
     * @var string
     */
    private $httpMethod;

    /**
     * @var Container[]
     */
    private $referencedContainers = [];

    /**
     * @return string
     */
    public function getPath(): string
    {
        return $this->path;
    }

    /**
     * @param string $path
     * @return EndpointDefinition
     */
    public function setPath(string $path): EndpointDefinition
    {
        $this->path = $path;
        return $this;
    }

    /**
     * @return string
     */
    public function getHttpMethod(): string
    {
        return $this->httpMethod;
    }

    /**
     * @param string $httpMethod
     * @return EndpointDefinition
     */
    public function setHttpMethod(string $httpMethod): EndpointDefinition
    {
        $this->httpMethod = $httpMethod;
        return $this;
    }

    /**
     * @return QueryParameters
     */
    public function getQueryParameters(): QueryParameters
    {
        return $this->queryParameters;
    }

    /**
     * @param QueryParameters $queryParameters
     * @return EndpointDefinition
     */
    public function setQueryParameters(QueryParameters $queryParameters): EndpointDefinition
    {
        $this->queryParameters = $queryParameters;
        return $this;
    }

    /**
     * @return RequestParameters
     */
    public function getRequestParameters(): RequestParameters
    {
        return $this->requestParameters;
    }

    /**
     * @param RequestParameters $requestParameters
     */
    public function setRequestParameters(RequestParameters $requestParameters): void
    {
        $this->requestParameters = $requestParameters;
    }

    public function mapResponseCode(int $code, $response)
    {
        $this->responseCodes[$code] = $response;
    }

    /**
     * @return PropertyInterface[]
     */
    public function getPathParameters(): array
    {
        return $this->pathParameters;
    }

    /**
     * @param PropertyInterface[] $pathParameters
     * @return EndpointDefinition
     */
    public function setPathParameters(array $pathParameters): EndpointDefinition
    {
        $this->pathParameters = $pathParameters;
        return $this;
    }

    /**
     * @param PropertyInterface $pathParameter
     */
    public function addPathParameter(PropertyInterface $pathParameter)
    {
        $this->pathParameters[] = $pathParameter;
    }

    public function write()
    {
        $containerWriter = new \Gen\ClassTypeWriter('../src');

        if (null !== $this->requestParameters) {
            $genContainer = new \Gen\Generate\ContainerGenerator();
            $node = $genContainer->generate($this->getRequestParameters());
            $dest = $containerWriter->write($this->getRequestParameters(), $node);
            echo $dest . "\n";
        }

        if (null !== $this->queryParameters) {
            $genContainer = new \Gen\Generate\ContainerGenerator();
            $node = $genContainer->generate($this->getQueryParameters());
            $dest = $containerWriter->write($this->getQueryParameters(), $node);
            echo $dest . "\n";
        }

        foreach ($this->referencedContainers as $container) {
            $genContainer = new \Gen\Generate\ContainerGenerator();
            $node = $genContainer->generate($container);
            $dest = $containerWriter->write($container, $node);
            echo $dest . "\n";
        }
    }

    /**
     * @return Container[]
     */
    public function getReferencedContainers(): array
    {
        return $this->referencedContainers;
    }

    /**
     * @param Container[] $referencedContainers
     * @return EndpointDefinition
     */
    public function setReferencedContainers(array $referencedContainers): EndpointDefinition
    {
        $this->referencedContainers = $referencedContainers;
        return $this;
    }

    public function addReferencedContainer(Container $container) : EndpointDefinition
    {
        $this->referencedContainers[] = $container;
        return $this;
    }

}