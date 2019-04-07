<?php
/**
 * Created by PhpStorm.
 * User: fromz
 * Date: 7/04/19
 * Time: 10:51 AM
 */

namespace Gen\Entity;


interface PropertyInterface
{
    public function setNullable($nullable);

    public function getNullable() : bool;

    public function setDescription(?string $description);

    public function getDescription() : ?string;
}