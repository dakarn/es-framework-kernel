<?php
/**
 * Created by PhpStorm.
 * User: v.konovalov
 * Date: 23.11.2018
 * Time: 15:45
 */

namespace ElasticSearchNew\QueryTypes;

use ElasticSearchNew\ElasticConnection;
use ElasticSearchNew\QueryOptions\ElasticQueryParams;
use ElasticSearchNew\QueryOptions\HttpQuery;
use Http\Request\Request;

class Insert extends ElasticQueryParams implements RequestOperationInterface
{
    /**
     * @param ElasticConnection $connect
     * @return HttpQuery
     */
    public function buildParams(ElasticConnection $connect): HttpQuery
    {
	    $this->httpQuery = new HttpQuery();

        $host = $connect->getSchema() . '://' . $connect->getHost() . ':' . $connect->getPort() . '/';

        if (empty($this->id)) {
            $pathname = $this->index . '/' . $this->type . '/';
            $method   = Request::POST;
        } else {
            $pathname = $this->index . '/' . $this->type . '/' . $this->id;
            $method   = Request::PUT;
        }

	    $this->httpQuery->setUrl($host . $pathname);
	    $this->httpQuery->setMethod($method);
	    $this->httpQuery->setQueryArray($this->query);

        return $this->httpQuery;
    }
}