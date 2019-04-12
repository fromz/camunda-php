<?php
/**
 * Created by PhpStorm.
 * User: fromz
 * Date: 12/04/19
 * Time: 3:41 PM
 */

namespace Gen\Service;


use Gen\Entity\Container;

class ResponseContent extends Container implements ResponseInterface
{
    public function isException(): bool
    {
        return false;
    }

    public function isReturnType(): bool
    {
        return true;
    }
}