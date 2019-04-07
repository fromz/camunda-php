<?php
/**
 * Created by PhpStorm.
 * User: fromz
 * Date: 7/04/19
 * Time: 7:03 AM.
 */

namespace Camunda;

use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

trait JsonDeserializerTrait
{
    protected function getJsonDeserializer(): Serializer
    {
        $encoders = [new JsonEncoder()];
        $normalizers = [new ObjectNormalizer()];

        return new Serializer($normalizers, $encoders);
    }

    /**
     * @param string $class
     * @param string $data
     *
     * @return mixed
     */
    protected function deserializeJson(string $class, string $data)
    {
        return $this->getJsonDeserializer()->deserialize(
            $data,
            $class,
            'json'
        );
    }
}
