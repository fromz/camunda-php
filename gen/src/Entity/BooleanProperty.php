<?php
/**
 * Created by PhpStorm.
 * User: fromz
 * Date: 7/04/19
 * Time: 10:52 AM
 */

namespace Gen\Entity;


class BooleanProperty extends AbstractProperty
{
    public function getPhpPropertyType(): string
    {
        return 'bool';
    }
}