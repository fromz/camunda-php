<?php

use Gen\Entity\Container;

require_once "vendor/autoload.php";

$spec = file_get_contents('swagger-fixed.json');
$decodedSpec = \json_decode($spec);

// Service:
//  has operations (GET /external-task)
//      may or may not have query parameters (QueryParameters-extends Container)
//      may or may not have body parameters (RequestParameters-extends Container)
//      has whitelist status codes
//      all other status codes generate exceptions

$document = new Swagger\Document($decodedSpec);
$mapper = new \Gen\SwaggerAdapter\SwaggerMapper($document);
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