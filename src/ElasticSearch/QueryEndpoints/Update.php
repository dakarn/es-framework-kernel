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

class Update extends ElasticQueryParams
{
	/**
	 * @var array
	 */
	private $queryUpdate = [];

    /**
     * @param ElasticConnection $elasticConnect
     * @return HttpQuery
     */
    public function buildQuery(ElasticConnection $elasticConnect): HttpQuery
    {
        $host = $this->makeHost($elasticConnect);

	    if (!empty($this->queryUpdate)) {
		    list($pathname, $method) = $this->makeByQueryUpdate();
	    } else {
		    list($pathname, $method) = $this->makeSimpleUpdate();
	    }

	    $this->httpQuery->setUrl($host . $pathname);
	    $this->httpQuery->setMethod($method);
	    $this->httpQuery->setQueryArray($this->query);

        return $this->httpQuery;
    }

	/**
	 * @param array $queryUpdate
	 * @return Update
	 */
    public function byQuery(array $queryUpdate): Update
    {
    	$this->queryUpdate = $queryUpdate;
    	$this->setIsUseByQuery(true);

    	return $this;
    }

	/**
	 * @return array
	 */
    private function makeByQueryUpdate(): array
    {
	    $pathname = $this->index . '/';

	    if (!empty($this->type)) {
		    $pathname .= $this->type .'/';
	    }

	    $this->query = $this->queryUpdate;

	    return [
		    $pathname . HttpCommandsInterface::UPDATE_QUERY,
		    Request::POST
	    ];
    }

	/**
	 * @return array
	 */
    private function makeSimpleUpdate(): array
    {
	    return [
	    	$this->index . '/' . $this->type .'/' . $this->id,
		    Request::PUT
	    ];
    }
}