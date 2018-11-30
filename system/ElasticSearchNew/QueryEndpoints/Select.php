<?php
/**
 * Created by PhpStorm.
 * User: v.konovalov
 * Date: 23.11.2018
 * Time: 15:44
 */

namespace ElasticSearchNew\QueryEndpoints;

use ElasticSearchNew\ElasticConnection;
use ElasticSearchNew\QueryOptions\ElasticQueryParams;
use ElasticSearchNew\QueryOptions\HttpQuery;
use Http\Request\Request;

class Select
{
    use ElasticQueryParams;

    /**
     * @param ElasticConnection $connect
     * @return HttpQuery
     */
    public function buildParams(ElasticConnection $connect): HttpQuery
    {
        $host     = $this->makeHost($connect);
        $pathname = $this->index . '/' . $this->type .'/' . $this->id;

	    $this->httpQuery->setUrl($host . $pathname);
	    $this->httpQuery->setMethod(Request::GET);

        return $this->httpQuery;
    }
}