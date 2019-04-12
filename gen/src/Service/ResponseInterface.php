<?php
/**
 * Created by PhpStorm.
 * User: fromz
 * Date: 13/04/19
 * Time: 8:49 AM
 */

namespace Gen\Service;


interface ResponseInterface
{
    public function isException() : bool;

    public function isReturnType() : bool;

}