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

class Update
{
    use ElasticQueryParams;

	/**
	 * @var array
	 */
	private $queryUpdate = [];

    /**
     * @param ElasticConnection $connect
     * @return HttpQuery
     */
    public function buildParams(ElasticConnection $connect): HttpQuery
    {
        $host = $this->makeHost($connect);

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