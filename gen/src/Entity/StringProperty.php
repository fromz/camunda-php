<?php
/**
 * Created by PhpStorm.
 * User: fromz
 * Date: 7/04/19
 * Time: 10:52 AM
 */

namespace Gen\Entity;


class StringProperty extends AbstractProperty
{
    public function getPhpPropertyType(): string
    {
        return 'string';
    }
}