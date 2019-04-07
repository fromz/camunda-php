<?php
/**
 * Created by PhpStorm.
 * User: fromz
 * Date: 7/04/19
 * Time: 10:52 AM
 */

namespace Gen\Entity;


class ArrayProperty extends AbstractProperty
{

    /**
     * @var AbstractProperty
     */
    private $childType;

    /**
     * @param AbstractProperty $childType
     */
    public function setChildType(AbstractProperty $childType)
    {
        $this->childType = $childType;
    }

    public function getChildType() : AbstractProperty
    {
        return $this->childType;
    }
}