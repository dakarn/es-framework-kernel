<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 26.11.2018
 * Time: 20:38
 */

namespace ElasticSearch\Response;

use ElasticSearch\ElasticSearch;
use ElasticSearch\QueryEndpoints\Search;
use ElasticSearch\QueryEndpoints\Select;
use Helper\Util;

class ElasticResultFactory
{
    /**
     * @param string $response
     * @param ElasticSearch $elasticSearchNew
     * @return AbstractResponse
     * @throws \Exception\ObjectException
     */
	public static function getResponseObject(string $response, ElasticSearch $elasticSearchNew): AbstractResponse
	{
        $currentQuery = $elasticSearchNew->getCurrentQueryType();

        switch (true) {
            case self::hasError($response):
                return new ErrorResponse($response);
            case $currentQuery instanceof Search:
                return new SearchResponse($response);
            case $currentQuery instanceof Select:
                return new SelectResponse($response);
            case $currentQuery->isUseByQuery():
                return new OperationByQueryResponse($response);
            default:
                return new ExecuteResponse($response);
        }
	}

    /**
     * @param string $response
     * @return bool
     */
	private static function hasError(string $response): bool
    {
        return !empty(Util::jsonDecode($response)['error']);
    }
}