<?php
require_once "vendor/autoload.php";

$spec = file_get_contents('swagger-fixed.json');
$decodedSpec = json_decode($spec);

$document = new Swagger\Document($decodedSpec);

$s = $document->getSchemaResolver()->findSchemaForType('ResourceOptionsDto');