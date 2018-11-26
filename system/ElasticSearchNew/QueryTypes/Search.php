<?php
/**
 * Created by PhpStorm.
 * User: v.konovalov
 * Date: 26.11.2018
 * Time: 11:02
 */

namespace ElasticSearchNew\QueryTypes;

use ElasticSearchNew\ElasticConnection;
use ElasticSearchNew\QueryOptions\ElasticQueryParams;
use ElasticSearchNew\QueryOptions\HttpQuery;
use Http\Request\Request;

class Search extends ElasticQueryParams
{
    private const SEARCH = '/_search/';

    /**
     * @param ElasticConnection $connect
     * @return HttpQuery
     */
    public function buildParams(ElasticConnection $connect): HttpQuery
    {
        $httpQuery = new HttpQuery();

        $host     = $connect->getSchema() . '://' . $connect->getHost() . ':' . $connect->getPort() . '/';
        $pathname = $this->index . self::SEARCH;

        $httpQuery->setUrl($host . $pathname);
        $httpQuery->setMethod(Request::GET);
        $httpQuery->setQueryArray($this->query);

        return $httpQuery;
    }
}