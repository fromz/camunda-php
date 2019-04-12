<?php
/**
 * Created by PhpStorm.
 * User: fromz
 * Date: 12/04/19
 * Time: 3:42 PM
 */

namespace Gen\Service;


class Response
{
    /**
     * @var ResponseParameters|null
     */
    private $responseParameters;

    /**
     * @var ExceptionDefinition|null
     */
    private $exceptionDefinition;

    /**
     * @return ResponseParameters|null
     */
    public function getResponseParameters(): ?ResponseParameters
    {
        return $this->responseParameters;
    }

    /**
     * @param ResponseParameters|null $responseParameters
     * @return Response
     */
    public function setResponseParameters(?ResponseParameters $responseParameters): Response
    {
        $this->responseParameters = $responseParameters;
        return $this;
    }

    /**
     * @return ExceptionDefinition|null
     */
    public function getExceptionDefinition(): ?ExceptionDefinition
    {
        return $this->exceptionDefinition;
    }

    /**
     * @param ExceptionDefinition|null $exceptionDefinition
     * @return Response
     */
    public function setExceptionDefinition(?ExceptionDefinition $exceptionDefinition): Response
    {
        $this->exceptionDefinition = $exceptionDefinition;
        return $this;
    }


}