<?php
namespace Camunda;

class GuzzleFetcher
{
    /**
     * @var string
     */
    private $base_uri;

    public function __construct(string $base_uri)
    {
        $this->base_uri = $base_uri;
    }

    public function fetch() : \GuzzleHttp\Client
    {
        return new \GuzzleHttp\Client([
            // Base URI is used with relative requests
            'base_uri' => $this->base_uri,
            // You can set any number of default request options.
            'timeout'  => 2.0,
        ]);
    }
}
