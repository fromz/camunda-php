<?php
require_once "vendor/autoload.php";

use PhpParser\PrettyPrinter;

$spec = file_get_contents('swagger-fixed.json');
$decodedSpec = json_decode($spec);

$document = new Swagger\Document($decodedSpec);

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

$context = new \Gen\Generate\Context();
$context->setMap($map);

$srcDir = '../src';

$schemaConverter = new \Gen\SchemaConverter($document);
$genContainer = new \Gen\Generate\ContainerGenerator($context);
foreach ($map as $schema => $generatorDetails) {
    $container = $schemaConverter->convertReferenceToContainer($schema);
    $node = $genContainer->generate($schema, $container);

    // Write the contents to disk
    $stmts = array($node->getNode());
    $prettyPrinter = new PrettyPrinter\Standard();
    $fileContents = $prettyPrinter->prettyPrintFile($stmts);
    $destinationDir = sprintf(
        '%s/%s',
        $srcDir,
        str_replace('\\', '/', removeFirstNamespacePart($generatorDetails['namespace']))
    );
    $destinationFile = $generatorDetails['class'];
    $destinationFullFilepath = sprintf('%s/%s.php', $destinationDir, $destinationFile);
    if (false === file_exists($destinationDir)) {
        mkdir($destinationDir, 0777, true);
    }
    file_put_contents($destinationFullFilepath, $fileContents);
}

function removeFirstNamespacePart($namespace)
{
    $parts = explode('\\', $namespace);
    array_shift($parts);
    return implode('\\', $parts);
}