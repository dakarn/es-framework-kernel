<?php
/**
 * Created by PhpStorm.
 * User: v.konovalov
 * Date: 23.11.2018
 * Time: 15:44
 */

namespace ElasticSearchNew\QueryTypes;

use ElasticSearchNew\ElasticConnection;
use ElasticSearchNew\QueryOptions\ElasticQueryParams;
use ElasticSearchNew\QueryOptions\HttpQuery;
use Http\Request\Request;

class Remove extends ElasticQueryParams
{
    /**
     * @param ElasticConnection $connect
     * @return HttpQuery
     */
    public function buildParams(ElasticConnection $connect): HttpQuery
    {
        $httpQuery = new HttpQuery();

        $host     = $connect->getSchema() . '://' . $connect->getHost() . ':' . $connect->getPort() . '/';
        $pathname = $this->index . '/' . $this->type .'/' . $this->id;

        $httpQuery->setUrl($host . $pathname);
        $httpQuery->setMethod(Request::DELETE);

        return $httpQuery;
    }
}