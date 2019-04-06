<?php
/**
 * Created by IntelliJ IDEA.
 * User: hentschel
 * Date: 30.10.13
 * Time: 11:45
 * To change this template use File | Settings | File Templates.
 */

namespace Camunda\Response;

class Form
{
    protected $key;
    protected $contextPath;

    /**
     * @param mixed $contextPath
     */
    public function setContextPath($contextPath)
    {
        $this->contextPath = $contextPath;
    }

    /**
     * @return mixed
     */
    public function getContextPath()
    {
        return $this->contextPath;
    }

    /**
     * @param mixed $key
     */
    public function setKey($key)
    {
        $this->key = $key;
    }

    /**
     * @return mixed
     */
    public function getKey()
    {
        return $this->key;
    }
}
