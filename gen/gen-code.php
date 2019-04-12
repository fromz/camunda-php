<?php
require_once "vendor/autoload.php";

$spec = file_get_contents('swagger-fixed.json');
$decodedSpec = \json_decode($spec);

$document = new Swagger\Document($decodedSpec);

$srcDir = '../src';

$map = [
    '#/definitions/FetchExternalTasksDto' => [
        'namespace' => 'Camunda\ExternalTask',
        'class' => 'FetchAndLockRequest',
    ],
    '#/definitions/FetchExternalTaskTopicDto' => [
        'namespace' => 'Camunda\ExternalTask',
        'class' => 'FetchExternalTaskTopic',
    ],
];

$containerWriter = new \Gen\ContainerWriter('../src');
$schemaConverter = new \Gen\SchemaConverter($document);
$genContainer = new \Gen\Generate\ContainerGenerator();
foreach ($map as $schema => $generatorDetails) {
    $container = $schemaConverter->convertReferenceToContainer($schema);
    $container->setNamespace($generatorDetails['namespace']);
    $container->setClass($generatorDetails['class']);
    $node = $genContainer->generate($container);
    $containerWriter->write($container, $node);
}

function removeFirstNamespacePart($namespace)
{
    $parts = explode('\\', $namespace);
    array_shift($parts);
    return implode('\\', $parts);
}