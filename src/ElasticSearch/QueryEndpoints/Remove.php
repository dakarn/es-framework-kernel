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
use ES\Kernel\ElasticSearch\QueryOptions\HttpCommandsInterface;
use ES\Kernel\ElasticSearch\QueryOptions\HttpQuery;
use ES\Kernel\Http\Request\Request;

class Remove extends ElasticQueryParams
{
	/**
	 * @var array
	 */
	private $queryByRemove = [];

    /**
     * @param ElasticConnection $elasticConnect
     * @return HttpQuery
     */
    public function buildQuery(ElasticConnection $elasticConnect): HttpQuery
    {
        $host = $this->makeHost($elasticConnect);

        if (!empty($this->queryByRemove)) {
	        $pathname = $this->index . '/' . HttpCommandsInterface::DELETE_QUERY;
	        $method   = Request::POST;
	        $this->httpQuery->setQueryArray($this->queryByRemove);
        } else {
	        $pathname = $this->index . '/' . $this->type .'/' . $this->id;
	        $method   = Request::DELETE;
        }

	    $this->httpQuery->setUrl($host . $pathname);
	    $this->httpQuery->setMethod($method);

        return $this->httpQuery;
    }

	/**
	 * @param array $queryRemove
	 * @return Remove
	 */
	public function byQuery(array $queryRemove): Remove
	{
		$this->queryByRemove = $queryRemove;
        $this->setIsUseByQuery(true);

        return $this;
	}

}