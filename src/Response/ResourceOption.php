<?php
/**
 * Created by IntelliJ IDEA.
 * User: hentschel
 * Date: 30.10.13
 * Time: 09:59
 * To change this template use File | Settings | File Templates.
 */

namespace Camunda\Response;

class ResourceOption
{
    protected $links;

    /**
     * @param mixed $links
     */
    public function setLinks($links)
    {
        $this->links = $links;
    }

    /**
     * @return mixed
     */
    public function getLinks()
    {
        return $this->links;
    }
}
