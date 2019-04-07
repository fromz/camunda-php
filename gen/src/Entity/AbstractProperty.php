<?php
/**
 * Created by PhpStorm.
 * User: fromz
 * Date: 7/04/19
 * Time: 11:06 AM
 */

namespace Gen\Entity;


abstract class AbstractProperty implements PropertyInterface
{
    /**
     * @var bool
     */
    private $nullable = false;

    public function setNullable($nullable)
    {
        $this->nullable = $nullable;
    }

    public function getNullable() : bool
    {
        return $this->nullable;
    }

    private $description = null;

    public function setDescription(?string $description)
    {
        $this->description = $description;
    }

    public function getDescription() : ?string
    {
        return $this->description;
    }

}