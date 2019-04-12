<?php
/**
 * Created by PhpStorm.
 * User: fromz
 * Date: 13/04/19
 * Time: 7:24 AM
 */

namespace Gen\SwaggerAdapter;


use Gen\Entity\Container;

class SchemaReference
{
    /**
     * @var string
     */
    private $schema;

    /**
     * @var Container
     */
    private $container;

    public function __construct(string $schema, Container $container)
    {
        $this->schema = $schema;
        $this->container = $container;
    }

    /**
     * @return string
     */
    public function getSchema(): string
    {
        return $this->schema;
    }

    /**
     * @param string $schema
     * @return SchemaReference
     */
    public function setSchema(string $schema): SchemaReference
    {
        $this->schema = $schema;
        return $this;
    }

    /**
     * @return Container
     */
    public function getContainer(): Container
    {
        return $this->container;
    }

    /**
     * @param Container $container
     * @return SchemaReference
     */
    public function setContainer(Container $container): SchemaReference
    {
        $this->container = $container;
        return $this;
    }


}