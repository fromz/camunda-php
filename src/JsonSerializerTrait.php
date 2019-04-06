<?php
/**
 * Created by PhpStorm.
 * User: fromz
 * Date: 7/04/19
 * Time: 7:03 AM
 */

namespace Camunda;


use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

trait JsonSerializerTrait
{
    protected function getJsonSerializer() : Serializer
    {
        $encoders = [new JsonEncoder()];
        $normalizers = [new ObjectNormalizer()];
        return new Serializer($normalizers, $encoders);
    }

    /**
     * @param $object
     * @return mixed
     */
    protected function serializeToJson($object)
    {
        return $this->getJsonSerializer()->serialize(
            $object,
            'json'
        );
    }
}