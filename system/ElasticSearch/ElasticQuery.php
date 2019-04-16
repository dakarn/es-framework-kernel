<?php
/**
 * Created by PhpStorm.
 * User: v.konovalov
 * Date: 23.11.2018
 * Time: 15:46
 */

namespace ElasticSearch;

use ElasticSearch\QueryOptions\ElasticQueryParams;
use ElasticSearch\QueryOptions\HttpQuery;
use ElasticSearch\Response\AbstractResponse;
use ElasticSearch\Response\ElasticResultFactory;
use Exception\HttpException;
use Traits\SingletonTrait;

class ElasticQuery
{
    use SingletonTrait;

    /**
     * @var
     */
    private $elasticQueryParams;

    /**
     * @var HttpQuery
     */
    private $httpQuery;

    /**
     * @var
     */
    private $curl;

    /**
     * @param ElasticQueryParams $elasticQueryParams
     * @return AbstractResponse
     * @throws HttpException
     * @throws \Exception\FileException
     * @throws \Exception\ObjectException
     */
    public function execute(ElasticQueryParams $elasticQueryParams): AbstractResponse
    {
        $this->elasticQueryParams = $elasticQueryParams;
        $this->httpQuery          = $elasticQueryParams->buildQuery(ElasticSearch::create()->getConfigConnection());

        $result = $this->doRequest();

        if (empty($result)) {
            throw new HttpException('Unable to connect with Elastic Search!');
        }

        return ElasticResultFactory::factory($result, ElasticSearch::create());
    }

    /**
     * @return mixed
     */
    private function doRequest()
    {
        $this->curl = \curl_init($this->httpQuery->getFullUrl());

        \curl_setopt($this->curl, CURLOPT_TIMEOUT, 5);
        \curl_setopt($this->curl, CURLOPT_RETURNTRANSFER, true);

        foreach ($this->httpQuery->getHeaders() as $headerName => $headerValue) {
            \curl_setopt($this->curl, CURLOPT_HTTPHEADER, [$headerName . ':' . $headerValue]);
        }

        \curl_setopt($this->curl, CURLOPT_CUSTOMREQUEST, $this->httpQuery->getMethod());

        if (!empty($this->httpQuery->getQueryString())) {
            \curl_setopt($this->curl, CURLOPT_POSTFIELDS, $this->httpQuery->getQueryString());
        }

        $result = \curl_exec($this->curl);
        \curl_close($this->curl);

        return $result;
    }
}