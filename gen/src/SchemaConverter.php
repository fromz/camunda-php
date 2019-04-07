<?php
/**
 * Created by PhpStorm.
 * User: fromz
 * Date: 7/04/19
 * Time: 11:27 AM
 */

namespace Gen;


class SchemaConverter
{
    /**
     * @var \Swagger\Document
     */
    private $document;

    public function __construct(\Swagger\Document $document)
    {
        $this->document = $document;
    }

    public function convertReferenceToContainer(string $schema) : Entity\Container
    {
        $schemaReference = $schema;
        $schema = str_replace('#/definitions/', '', $schema);
        $s = $this->document->getSchemaResolver()->findSchemaForType($schema);
        /* @var $s \Swagger\Object\Schema */
        switch ($s->getType()) {
            case 'object':
                $container = new Entity\Container();
                $container->setSchemaReference($schemaReference);
                // append children to container
                foreach ($s->getProperties()->getDocument() as $name => $schemaProperty) {
                    /* @var $schemaProperty \stdClass */
                    $entityProperty = $this->schemaPropertyToEntityProperty($schemaProperty);
                    $container->addChild($name, $entityProperty);
                }
                break;
            default:
                throw new Exception(sprintf('Unsure how to support Schema type %s', $s->getType()));
        }
        return $container;
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
                    $childType = $this->convertReferenceToContainer($schemaProperty->items->{'$ref'});
                    $classProperty->setChildType($childType);
                    return $classProperty;
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