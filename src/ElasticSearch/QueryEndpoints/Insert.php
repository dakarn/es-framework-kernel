<?php
/**
 * Created by PhpStorm.
 * User: v.konovalov
 * Date: 23.11.2018
 * Time: 15:45
 */

namespace ElasticSearch\QueryEndpoints;

use ElasticSearch\ElasticConnection;
use ElasticSearch\QueryOptions\ElasticQueryParams;
use ElasticSearch\QueryOptions\HttpQuery;
use Http\Request\Request;

class Insert extends ElasticQueryParams
{
    /**
     * @param ElasticConnection $elasticConnect
     * @return HttpQuery
     */
    public function buildQuery(ElasticConnection $elasticConnect): HttpQuery
    {
        $host = $this->makeHost($elasticConnect);

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