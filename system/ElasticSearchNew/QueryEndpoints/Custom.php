<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 04.12.2018
 * Time: 18:53
 */

namespace ElasticSearchNew\QueryEndpoints;

use ElasticSearchNew\ElasticConnection;
use ElasticSearchNew\QueryOptions\ElasticQueryParams;
use ElasticSearchNew\QueryOptions\HttpQuery;

class Custom
{
	use ElasticQueryParams;

	/**
	 * @param ElasticConnection $elasticConnect
	 * @return HttpQuery
	 */
	public function buildQuery(ElasticConnection $elasticConnect): HttpQuery
	{
		$this->httpQuery->setUrl( $this->makeHost($elasticConnect) . $this->customQuery['path']);
		$this->httpQuery->setMethod($this->customQuery['method']);
		$this->httpQuery->setQueryArray($this->customQuery['query']);

		return $this->httpQuery;
	}
}