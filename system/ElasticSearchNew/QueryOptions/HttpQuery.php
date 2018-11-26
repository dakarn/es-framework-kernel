<?php
/**
 * Created by PhpStorm.
 * User: v.konovalov
 * Date: 26.11.2018
 * Time: 11:25
 */

namespace ElasticSearchNew\QueryOptions;

class HttpQuery
{
    /**
     * @var string
     */
    private $url = '';

    /**
     * @var string
     */
    private $host = '';

    /**
     * @var string
     */
    private $port = '';

    /**
     * @var string
     */
    private $pathname = '';

    /**
     * @var string
     */
    private $method = '';

    /**
     * @var string
     */
    private $queryString = '';

    /**
     * @var array
     */
    private $headers = [];

    /**
     * @return string
     */
    public function getFullUrl(): string
    {
        return $this->url;
    }

    /**
     * @param string $url
     */
    public function setUrl(string $url)
    {
        $this->url = $url;
    }

    /**
     * @return string
     */
    public function getHost(): string
    {
        return $this->host;
    }

    /**
     * @param string $host
     */
    public function setHost(string $host)
    {
        $this->host = $host;
    }

    /**
     * @return string
     */
    public function getPort(): string
    {
        return $this->port;
    }

    /**
     * @param string $port
     */
    public function setPort(string $port)
    {
        $this->port = $port;
    }

    /**
     * @return string
     */
    public function getPathname(): string
    {
        return $this->pathname;
    }

    /**
     * @param string $pathname
     */
    public function setPathname(string $pathname)
    {
        $this->pathname = $pathname;
    }

    /**
     * @return string
     */
    public function getMethod(): string
    {
        return $this->method;
    }

    /**
     * @param string $method
     */
    public function setMethod(string $method)
    {
        $this->method = $method;
    }

    /**
     * @return string
     */
    public function getQueryString(): string
    {
        return $this->queryString;
    }

    /**
     * @param string $queryString
     */
    public function setQueryString(string $queryString)
    {
        $this->queryString = $queryString;
    }

    public function setQueryArray(array $queryArray)
    {
        $this->queryString = \json_encode($queryArray);
    }

    /**
     * @return array
     */
    public function getHeaders(): array
    {
        return $this->headers;
    }

    /**
     * @param array $headers
     */
    public function setHeaders(array $headers)
    {
        $this->headers = $headers;
    }
}