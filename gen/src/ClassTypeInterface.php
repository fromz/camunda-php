<?php
/**
 * Created by PhpStorm.
 * User: fromz
 * Date: 13/04/19
 * Time: 4:35 AM
 */

namespace Gen;


interface ClassTypeInterface
{
    public function getClass() : string;
    public function setClass(string $class);
    public function getNamespace() : string;
    public function setNamespace(string $namespace);
    public function hasExtends() : bool;
    public function getExtends() : ClassTypeInterface;
    public function setExtends(ClassTypeInterface $classType);
    public function getFqn() : string;
}