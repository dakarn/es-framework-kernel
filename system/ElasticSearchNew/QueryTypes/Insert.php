<?php
/**
 * Created by PhpStorm.
 * User: v.konovalov
 * Date: 23.11.2018
 * Time: 15:45
 */

namespace ElasticSearchNew\QueryTypes;

use ElasticSearchNew\ElasticConnect;
use ElasticSearchNew\QueryOptions\ElasticQueryParams;
use ElasticSearchNew\QueryOptions\HttpQuery;
use Http\Request\Request;

class Insert extends ElasticQueryParams
{
    public function buildParams(ElasticConnect $connect): HttpQuery
    {
        $httpQuery = new HttpQuery();

        $httpQuery->setHeaders([
            'Content-type' => 'application/json'
        ]);

        $host     = $connect->getSchema() . '://' . $connect->getHost() . ':' . $connect->getPort() . '/';
        $pathname = $this->index . '/' . $this->type .'/';

        $httpQuery->setUrl($host . $pathname);
        $httpQuery->setMethod(Request::POST);
        $httpQuery->setQueryArray($this->query);

        return $httpQuery;
    }
}