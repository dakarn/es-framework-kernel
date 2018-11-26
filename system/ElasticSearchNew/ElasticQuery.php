<?php
/**
 * Created by PhpStorm.
 * User: v.konovalov
 * Date: 23.11.2018
 * Time: 15:46
 */

namespace ElasticSearchNew;

use Configs\Config;
use ElasticSearchNew\QueryOptions\ElasticQueryParams;
use ElasticSearchNew\QueryOptions\HttpQuery;
use Traits\SingletonTrait;

class ElasticQuery
{
    use SingletonTrait;

    private $elasticQueryParams;

    /**
     * @var HttpQuery
     */
    private $httpQuery;

    private $curl;

    public function execute(ElasticQueryParams $elasticQueryParams): ElasticResult
    {
        $this->elasticQueryParams = $elasticQueryParams;
        $this->httpQuery          = $elasticQueryParams->buildParams($this->getConfigConnect());

        return new ElasticResult($this->doRequest());
    }

    private function getConfigConnect(): ElasticConnect
    {
        $config = Config::get('elasticsearch');

        $elasticConnect = new ElasticConnect();

        $elasticConnect->setSchema($config['schema']);
        $elasticConnect->setPort($config['port']);
        $elasticConnect->setHost($config['host']);

        return $elasticConnect;
    }

    private function doRequest()
    {
        print_r($this->httpQuery);

        $this->curl = \curl_init($this->httpQuery->getFullUrl());

        \curl_setopt($this->curl, CURLOPT_TIMEOUT, 5);
        \curl_setopt($this->curl, CURLOPT_RETURNTRANSFER, true);

        foreach ($this->httpQuery->getHeaders() as $headerName => $headerValue) {
            \curl_setopt($this->curl, CURLOPT_HTTPHEADER, [$headerName . ':' . $headerValue]);
        }

        \curl_setopt($this->curl, CURLOPT_POST, true);
        \curl_setopt($this->curl, CURLOPT_POSTFIELDS, $this->httpQuery->getQueryString());

        $result = \curl_exec($this->curl);
        \curl_close($this->curl);

        return $result;
    }
}