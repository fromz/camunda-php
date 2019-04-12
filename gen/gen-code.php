<?php

use Gen\Entity\Container;

require_once "vendor/autoload.php";

// Correct their swagger details
$spec = file_get_contents('swagger-fixed.json');
$jsonArray = json_decode($spec, true);
$jsonArray = swapSchemaResponse($jsonArray, '/external-task', 'get', '200', [
    'type' => 'array',
    'items' => [
        '$ref' => '#/definitions/ExternalTaskDto'
    ]
]);
function swapSchemaResponse(array $decodedSpec, string $path, string $operation, string $responseCode, array $to) : array {
    $decodedSpec['paths'][$path][$operation]['responses'][$responseCode]['schema'] = $to;
    return $decodedSpec;
}
file_put_contents('swagger-fixed-corrected.json', json_encode($jsonArray));


$spec = file_get_contents('swagger-fixed-corrected.json');
$decodedSpec = \json_decode($spec);
$document = new Swagger\Document($decodedSpec);
$mapper = new \Gen\SwaggerAdapter\SwaggerMapper($document);

// Service is made up of many endpoints
// Endpoint: (e.g. GET /external-task)
//  may or may not have query parameters (QueryParameters-extends Container)
//  may or may not have body parameters (RequestParameters-extends Container)
//  maps response codes to ResponseType (Exception,ResponseContent)
$endpoint = $mapper->pathToEndpoint('/external-task', 'get',
    (new \Gen\SwaggerAdapter\EndpointConfig())
        ->setQueryParamsAs((new \Gen\Service\QueryParameters())->setNamespace('Camunda\ExternalTask')->setClass('GetExternalTaskQueryParams'))
);
$endpoint->write();


$endpoint = $mapper->pathToEndpoint('/external-task/fetchAndLock', 'post',
    (new \Gen\SwaggerAdapter\EndpointConfig())
        ->setRequestParametersAs(
            (new \Gen\Service\RequestParameters())->setNamespace('Camunda\ExternalTask')->setClass('FetchAndLockRequestBody'),
            [
                new \Gen\SwaggerAdapter\SchemaReference(
                    '#/definitions/FetchExternalTaskTopicDto',
                    (new \Gen\Service\RequestParameters())->setNamespace('Camunda\ExternalTask')->setClass('FetchAndLockRequestBodyTopic')
                ),
            ]
        )
);
$endpoint->write();

// Fetch endpoint request parameters