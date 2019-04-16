<?php
/**
 * Created by PhpStorm.
 * User: v.konovalov
 * Date: 23.11.2018
 * Time: 15:44
 */

namespace ElasticSearch\QueryEndpoints;

use ElasticSearch\ElasticConnection;
use ElasticSearch\QueryOptions\ElasticQueryParams;
use ElasticSearch\QueryOptions\HttpCommandsInterface;
use ElasticSearch\QueryOptions\HttpQuery;
use Http\Request\Request;

class Remove
{
    use ElasticQueryParams;

	/**
	 * @var array
	 */
	private $queryByRemove = [];

    /**
     * @param ElasticConnection $connect
     * @return HttpQuery
     */
    public function buildQuery(ElasticConnection $connect): HttpQuery
    {
        $host = $this->makeHost($connect);

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

		return $this;
	}

}