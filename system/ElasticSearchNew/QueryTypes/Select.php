<?php
/**
 * Created by PhpStorm.
 * User: v.konovalov
 * Date: 23.11.2018
 * Time: 15:44
 */

namespace ElasticSearchNew\QueryTypes;

use ElasticSearchNew\ElasticConnect;
use ElasticSearchNew\QueryOptions\ElasticQueryParams;
use ElasticSearchNew\QueryOptions\HttpQuery;
use Http\Request\Request;

class Select extends ElasticQueryParams
{
    public function buildParams(ElasticConnect $elasticConnect): HttpQuery
    {
        $httpQuery = new HttpQuery();

        $httpQuery->setHeaders([
            'Content-type' => 'application/json'
        ]);

        $httpQuery->setUrl('http://elasticsearch/twitter/_doc/0');
        $httpQuery->setMethod(Request::GET);
        $httpQuery->setPort('9200');

        return $httpQuery;
    }
}