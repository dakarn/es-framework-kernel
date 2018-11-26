<?php
/**
 * Created by PhpStorm.
 * User: v.konovalov
 * Date: 26.11.2018
 * Time: 11:02
 */

namespace ElasticSearchNew\QueryEndpoints;

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
	    $this->httpQuery = new HttpQuery();

        $host     = $this->makeHost($connect);
        $pathname = $this->index . self::SEARCH;

	    $this->httpQuery->setUrl($host . $pathname);
	    $this->httpQuery->setMethod(Request::GET);
	    $this->httpQuery->setQueryArray($this->query);

        return $this->httpQuery;
    }
}