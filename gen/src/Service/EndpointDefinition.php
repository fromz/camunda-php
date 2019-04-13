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
use Gen\Generate\ExceptionGenerator;
use PharIo\Manifest\Url;

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
    private $pathParameters = [];

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
     * @var ResponseInterface[]
     */
    private $responses = [];

    public function addResponse(int $responseCode, ResponseInterface $response)
    {
        $this->responses[$responseCode] = $response;
    }

    /**
     * @return ResponseInterface[]
     */
    public function getResponses() : array
    {
        return $this->responses;
    }

    /**
     * @return PropertyInterface[]
     */
    public function getPathParameters(): array
    {
        return $this->pathParameters;
    }

    public function addPathParameter(string $name, PropertyInterface $parameter) : EndpointDefinition
    {
        $this->pathParameters[$name] = $parameter;
        return $this;
    }

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

    public function hasQueryParameters() : bool
    {
        return $this->queryParameters !== null;
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

    public function hasRequestParameters() : bool
    {
        return $this->requestParameters !== null;
    }

    /**
     * @param RequestParameters $requestParameters
     */
    public function setRequestParameters(RequestParameters $requestParameters): void
    {
        $this->requestParameters = $requestParameters;
    }

    public function write()
    {
        $classTypeWriter = new \Gen\ClassTypeWriter('../src');

        if (null !== $this->requestParameters) {
            echo $this->getRequestParameters()->getFqn() . "\n";
            $genContainer = new \Gen\Generate\ContainerGenerator();
            $ns = $genContainer->generate($this->getRequestParameters());
            $dest = $classTypeWriter->write($this->getRequestParameters(), $ns);
            echo $dest . "\n";
        }

        if (null !== $this->queryParameters) {
            echo $this->getQueryParameters()->getFqn() . "\n";
            $genContainer = new \Gen\Generate\ContainerGenerator();
            $ns = $genContainer->generate($this->getQueryParameters());
            $dest = $classTypeWriter->write($this->getQueryParameters(), $ns);
            echo $dest . "\n";
        }

        foreach ($this->referencedContainers as $container) {
            echo $container->getFqn() . "\n";
            $genContainer = new \Gen\Generate\ContainerGenerator();
            $ns = $genContainer->generate($container);
            $dest = $classTypeWriter->write($container, $ns);
            echo $dest . "\n";
        }

        // Generate response entities
        foreach ($this->responses as $code => $response) {
            echo $response->getFqn() . "\n";
            switch (get_class($response)) {
                case ResponseContent::class:
                    /* @var $response ResponseContent */
                    $genContainer = new \Gen\Generate\ContainerGenerator();
                    $ns = $genContainer->generate($response);
                    $dest = $classTypeWriter->write($response, $ns);
                    echo $dest . "\n";
                    break;
                case ResponseException::class:
                    /* @var $response ResponseException */
                    $exceptionGenerator = new ExceptionGenerator();
                    $ns = $exceptionGenerator->generate($response);
                    $dest = $classTypeWriter->write($response, $ns);
                    echo $dest . "\n";
                    break;
            }
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