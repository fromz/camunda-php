<?php
require_once "vendor/autoload.php";

// The spec provided by Camunda is invalid. This script fixes it.
$spec = file_get_contents('swagger.json');
$decodedSpec = json_decode($spec, true);


/**
 * ==============================
 * Fix up duplicate operation IDs
 * ==============================
 */
$operationIds = [];
foreach ($decodedSpec['paths'] as $pathKey => $pathData) {
    foreach ($pathData as $httpOperation => $endpointData) {
        if (false === \array_key_exists($endpointData['operationId'], $operationIds)) {
            $operationIds[$endpointData['operationId']] = [];
        }
        $operationIds[$endpointData['operationId']][] = [
            'path' => $pathKey,
            'httpOperation' => $httpOperation,
        ];
    }
}
foreach ($operationIds as $operationId => $info) {
    if (count($info) === 1) {
        continue;
    }
    foreach ($info as $duplicateIdEndpoint) {
        $replacementOperationId = genOperationId(
            $duplicateIdEndpoint['path'],
            $duplicateIdEndpoint['httpOperation']
        );
        $decodedSpec['paths']
            [$duplicateIdEndpoint['path']]
            [$duplicateIdEndpoint['httpOperation']]
            ['operationId'] = $replacementOperationId
        ;
    }
}

function genOperationId(string $path, string $httpOperation) : string
{
    $path = str_replace('-', '/', $path);
    $parts = [];
    $opParts = explode('/', $path);
    foreach ($opParts as $opPart) {
        if ('' === $opPart) {
            continue;
        }
        $parts[] = ucfirst(str_replace(['{','}'], '', $opPart));
    }
    if ('options' === $httpOperation) {
        // at the end
        return sprintf('%s%s', implode('', $parts), 'Options');
    }

    return sprintf('%s%s', ucfirst($httpOperation), implode('', $parts));
}


/**
 * ==============================
 * Fix up duplicate parameters
 * ==============================
 */
foreach ($decodedSpec['paths'] as $pathKey => $pathData) {
    foreach ($pathData as $httpOperation => $endpointData) {
        if (false === array_key_exists('parameters', $endpointData)) {
            continue;
        }
        $parameters = [];
        foreach ($endpointData['parameters'] as $paramKey => $param) {
            if (false === array_key_exists($param['name'], $parameters)) {
                $parameters[$param['name']] = [];
            }
            $parameters[$param['name']][$paramKey] = $param;
        }

        foreach ($parameters as $paramGroup) {
            if (1 === count($paramGroup)) { // not duplicate
                continue;
            }
            // @todo will need to be able to optionally select which to keep
            $paramKeys = array_keys($paramGroup);
            array_shift($paramKeys); // prefer the first one?
            foreach ($paramKeys as $remainingDuplicateParameterKey) {
                unset($decodedSpec['paths'][$pathKey][$httpOperation]['parameters'][$remainingDuplicateParameterKey]);
            }
        }
        // reset array keys so it serializes correctly
        $decodedSpec['paths'][$pathKey][$httpOperation]['parameters'] = array_values($decodedSpec['paths'][$pathKey][$httpOperation]['parameters']);
    }
}

file_put_contents('swagger-fixed.json', json_encode($decodedSpec));

