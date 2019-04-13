<?php
/**
 * Created by PhpStorm.
 * User: fromz
 * Date: 13/04/19
 * Time: 10:01 AM
 */

namespace Gen\Service;


use Gen\ClassTypeInterface;
use Gen\ClassTypeTrait;
use Gen\Generate\ServiceGenerator;

class Service implements ClassTypeInterface
{
    use ClassTypeTrait;

    /**
     * @var EndpointDefinition[]
     */
    private $endpoints = [];

    public function addEndpointDefinition(string $methodName, EndpointDefinition $endpoint) : Service
    {
        $this->endpoints[$methodName] = $endpoint;
        return $this;
    }

    /**
     * @return EndpointDefinition[]
     */
    public function getEndpointDefinitions() : array
    {
        return $this->endpoints;
    }


    public function write()
    {
        // Make a new class
        $classTypeWriter = new \Gen\ClassTypeWriter('../src');
        $serviceGenerator = new ServiceGenerator();
        $ns = $serviceGenerator->generate($this);
        $dest = $classTypeWriter->write($this, $ns);
        echo $dest . "\n";

        foreach ($this->endpoints as $endpoint) {
            $endpoint->write();
        }
    }
}