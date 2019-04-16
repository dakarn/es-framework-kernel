<?php
/**
 * Created by PhpStorm.
 * User: v.konovalov
 * Date: 26.11.2018
 * Time: 11:02
 */

namespace ElasticSearch\QueryEndpoints;

use ElasticSearch\ElasticConnection;
use ElasticSearch\QueryOptions\ElasticQueryParams;
use ElasticSearch\QueryOptions\HttpQuery;
use Http\Request\Request;

class Search
{
    use ElasticQueryParams;

    private const SEARCH = '/_search/';

    /**
     * @param ElasticConnection $connect
     * @return HttpQuery
     */
    public function buildQuery(ElasticConnection $connect): HttpQuery
    {
        $host     = $this->makeHost($connect);
        $pathname = $this->index . self::SEARCH;

	    $this->httpQuery->setUrl($host . $pathname);
	    $this->httpQuery->setMethod(Request::GET);
	    $this->httpQuery->setQueryArray($this->query);

        return $this->httpQuery;
    }
}