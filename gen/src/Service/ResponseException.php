<?php
/**
 * Created by PhpStorm.
 * User: fromz
 * Date: 12/04/19
 * Time: 3:44 PM
 */

namespace Gen\Service;


use Gen\ClassTypeInterface;
use Gen\ClassTypeTrait;

class ResponseException implements ResponseInterface, ClassTypeInterface
{

    use ClassTypeTrait;

    public function __construct()
    {
        $this->setExtends(new ConcreteException());
    }

    public function isException(): bool
    {
        return true;
    }

    public function isReturnType(): bool
    {
        return false;
    }
}