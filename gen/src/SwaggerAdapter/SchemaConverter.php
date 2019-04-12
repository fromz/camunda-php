<?php
/**
 * Created by PhpStorm.
 * User: fromz
 * Date: 7/04/19
 * Time: 11:27 AM
 */

namespace Gen\SwaggerAdapter;

use Gen\Entity;
use Exception;
use Gen\Service\RequestParameters;
use Gen\Service\ResponseContent;
use http\Env\Request;

class SchemaConverter
{
    /**
     * @var \Swagger\Document
     */
    private $document;

    /**
     * @var SchemaReference[]
     */
    private $schemaReferences;

    public function __construct(\Swagger\Document $document, $schemaReferences = [])
    {
        $this->document = $document;
        $this->schemaReferences = $schemaReferences;
    }

    public function applySchemaPropertiesToResponseContent(ResponseContent $container, string $schemaReference) : ResponseContent {
        $this->applySchemaPropertiesToContainer($container, $schemaReference);
        return $container;
    }

    public function applySchemaPropertiesToRequestParameters(RequestParameters $container, string $schemaReference) : RequestParameters {
        $this->applySchemaPropertiesToContainer($container, $schemaReference);
        return $container;
    }

    public function applySchemaPropertiesToContainer(Entity\Container $container, string $schemaReference)
    {
        $d = $this->document->getDefinitions();
        /* @var $d \Swagger\Object\Definitions */
        $schema = $d->getDefinition(str_replace('#/definitions/', '', $schemaReference));
        /* @var $schema \Swagger\Object\Schema */
        switch ($schema->getType()) {
            case 'object':
                // append children to container
                foreach ($schema->getProperties()->getDocument() as $name => $schemaProperty) {
                    /* @var $schemaProperty \stdClass */
                    $entityProperty = $this->schemaPropertyToEntityProperty($schemaProperty);
                    $container->addChild($name, $entityProperty);
                }
                break;
            default:
                throw new Exception(sprintf('Unsure how to support Schema type %s', $schema->getType()));
        }
    }

    private function schemaPropertyToEntityProperty(\stdClass $schemaProperty)
    {
        switch ($schemaProperty->type) {
            case 'integer':
                $classProperty = new Entity\IntegerProperty();
                $this->applyCommonSchemaProperties($schemaProperty, $classProperty);
                return $classProperty;
            case 'string':
                $classProperty = new Entity\StringProperty();
                $this->applyCommonSchemaProperties($schemaProperty, $classProperty);
                return $classProperty;
            case 'boolean':
                $classProperty = new Entity\BooleanProperty();
                $this->applyCommonSchemaProperties($schemaProperty, $classProperty);
                return $classProperty;
            case 'array':
                $classProperty = new Entity\ArrayProperty();
                $this->applyCommonSchemaProperties($schemaProperty, $classProperty);
                if (false === \property_exists($schemaProperty, 'items')) {
                    throw new Exception('This array does not have items defined.');
                }
                if (true === \property_exists($schemaProperty->items, '$ref')) {
                    // this array references another entity, gunna have to generate it
                    $ref = $schemaProperty->items->{'$ref'};
                    foreach ($this->schemaReferences as $schemaReference) {
                        if ($ref !== $schemaReference->getSchema()) {
                            continue;
                        }
                        $this->applySchemaPropertiesToContainer($schemaReference->getContainer(), $ref);
                        $classProperty->setChildType($schemaReference->getContainer());
                        return $classProperty;
                    }
                    throw new Exception('Dont seem to have a schema reference');
                }
                if (true === \property_exists($schemaProperty->items, 'type')) {
                    $childType = $this->schemaPropertyToEntityProperty($schemaProperty->items);
                    $classProperty->setChildType($childType);
                    return $classProperty;
                }
                throw new Exception('This array is unsupported.');
            default:
                throw new Exception(sprintf('Unsure how to support Schema property with type %s', $schemaProperty->type));
        }
    }

    private function applyCommonSchemaProperties(\stdClass $schemaProperty, \Gen\Entity\PropertyInterface $property)
    {
        $property->setNullable(false);
        if (true === \property_exists($schemaProperty, 'description')) {
            $property->setDescription($schemaProperty->description);
        }
    }
}