<?php
/**
 * Created by PhpStorm.
 * User: v.konovalov
 * Date: 26.11.2018
 * Time: 11:02
 */

namespace ES\Kernel\ElasticSearch\QueryEndpoints;

use ES\Kernel\ElasticSearch\ElasticConnection;
use ES\Kernel\ElasticSearch\QueryOptions\ElasticQueryParams;
use ES\Kernel\ElasticSearch\QueryOptions\HttpQuery;
use ES\Kernel\Http\Request\Request;

class Search extends ElasticQueryParams
{
    private const SEARCH = '/_search/';

    /**
     * @param ElasticConnection $elasticConnect
     * @return HttpQuery
     */
    public function buildQuery(ElasticConnection $elasticConnect): HttpQuery
    {
        $host     = $this->makeHost($elasticConnect);
        $pathname = $this->index . self::SEARCH;

	    $this->httpQuery->setUrl($host . $pathname);
	    $this->httpQuery->setMethod(Request::POST);
	    $this->httpQuery->setQueryArray($this->query);

        return $this->httpQuery;
    }
}