<?php

namespace ES\Kernel\ElasticSearch;

use ES\Kernel\ElasticSearch\QueryOptions\ElasticQueryParams;
use ES\Kernel\ElasticSearch\Response\AbstractResponse;

interface ElasticQueryInterface
{
	/**
	 * @param ElasticQueryParams $elasticQueryParams
	 * @return AbstractResponse
	 */
    public function execute(ElasticQueryParams $elasticQueryParams): AbstractResponse;
}