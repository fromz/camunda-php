<?php
/**
 * Created by PhpStorm.
 * User: fromz
 * Date: 13/04/19
 * Time: 6:40 AM
 */

namespace Gen\SwaggerAdapter;


use Gen\Entity\Container;
use Gen\Service\QueryParameters;
use Gen\Service\RequestParameters;

class EndpointConfig
{
    /**
     * @var QueryParameters
     */
    private $queryParamsAs;

    /**
     * @var RequestParameters
     */
    private $requestParametersAs;

    /**
     * @var SchemaReference[]
     */
    private $requestSchemaReferences = [];

    /**
     * @return QueryParameters
     */
    public function getQueryParamsAs(): QueryParameters
    {
        return $this->queryParamsAs;
    }

    public function hasQueryParamAs() : bool
    {
        return $this->queryParamsAs !== null;
    }

    /**
     * @param QueryParameters $queryParamsAs
     * @return EndpointConfig
     */
    public function setQueryParamsAs(QueryParameters $queryParamsAs): EndpointConfig
    {
        $this->queryParamsAs = $queryParamsAs;
        return $this;
    }

    /**
     * @return RequestParameters
     */
    public function getRequestParametersAs(): RequestParameters
    {
        return $this->requestParametersAs;
    }

    public function hasRequestParametersAs() : bool
    {
        return $this->requestParametersAs !== null;
    }

    /**
     * @param RequestParameters $requestParametersAs
     * @return EndpointConfig
     */
    public function setRequestParametersAs(RequestParameters $requestParametersAs, array $schemaReferences): EndpointConfig
    {
        $this->requestParametersAs = $requestParametersAs;
        $this->requestSchemaReferences = $schemaReferences;
        return $this;
    }

    /**
     * @return SchemaReference[]
     */
    public function getRequestSchemaReferences() : array
    {
        return $this->requestSchemaReferences;
    }

}