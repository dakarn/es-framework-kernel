<?php
/**
 * Created by PhpStorm.
 * User: v.konovalov
 * Date: 23.11.2018
 * Time: 15:44
 */

namespace ES\Kernel\ElasticSearch\QueryEndpoints;

use ES\Kernel\ElasticSearch\ElasticConnection;
use ES\Kernel\ElasticSearch\QueryOptions\ElasticQueryParams;
use ES\Kernel\ElasticSearch\QueryOptions\HttpQuery;
use ES\Kernel\Http\Request\Request;

class Select extends ElasticQueryParams
{
    /**
     * @param ElasticConnection $elasticConnect
     * @return HttpQuery
     */
    public function buildQuery(ElasticConnection $elasticConnect): HttpQuery
    {
        $host     = $this->makeHost($elasticConnect);
        $pathname = $this->index . '/' . $this->type .'/' . $this->id;

	    $this->httpQuery->setUrl($host . $pathname);
	    $this->httpQuery->setMethod(Request::GET);

        return $this->httpQuery;
    }
}