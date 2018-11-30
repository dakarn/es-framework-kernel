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
use ElasticSearchNew\QueryOptions\HttpCommandsInterface;
use ElasticSearchNew\QueryOptions\HttpQuery;
use Http\Request\Request;

class Remove
{
    use ElasticQueryParams;

	/**
	 * @var array
	 */
	private $queryRemove = [];

    /**
     * @param ElasticConnection $connect
     * @return HttpQuery
     */
    public function buildParams(ElasticConnection $connect): HttpQuery
    {
        $host = $this->makeHost($connect);

        if (!empty($this->queryRemove)) {
	        $pathname = $this->index . '/' . HttpCommandsInterface::DELETE_QUERY;
	        $method   = Request::POST;
	        $this->httpQuery->setQueryArray($this->queryRemove);
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
		$this->queryRemove = $queryRemove;

		return $this;
	}

}