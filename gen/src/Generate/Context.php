<?php
/**
 * Created by PhpStorm.
 * User: fromz
 * Date: 7/04/19
 * Time: 1:51 PM
 */

namespace Gen\Generate;


class Context
{
    /**
     * @var array
     */
    private $map;

    /**
     * @return array
     */
    public function getMap(): array
    {
        return $this->map;
    }

    /**
     * @param array $map
     */
    public function setMap(array $map): void
    {
        $this->map = $map;
    }

}