<?php
/**
 * Created by PhpStorm.
 * User: fromz
 * Date: 13/04/19
 * Time: 8:57 AM
 */

namespace Gen\Service;


use Gen\ClassTypeInterface;
use Gen\ClassTypeTrait;

class ConcreteException implements ClassTypeInterface
{
    use ClassTypeTrait;

    public function __construct()
    {
        $this->setClass('Exception');
        $this->setNamespace('');
    }
}