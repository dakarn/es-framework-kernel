<?php
/**
 * Created by PhpStorm.
 * User: v.konovalov
 * Date: 26.11.2018
 * Time: 11:25
 */

namespace ES\Kernel\ElasticSearch\QueryOptions;

class HttpQuery
{
    /**
     * @var string
     */
    private $url = '';

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
    private $headers = [
        'Content-type' => 'application/json'
    ];

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

    /**
     * @param array $queryArray
     */
    public function setQueryArray(array $queryArray)
    {
        $this->queryString = \json_encode($queryArray, JSON_UNESCAPED_UNICODE);
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