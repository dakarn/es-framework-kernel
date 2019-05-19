<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 26.11.2018
 * Time: 20:38
 */

namespace ES\Kernel\ElasticSearch\Response;

use ES\Kernel\ElasticSearch\ElasticSearch;
use ES\Kernel\ElasticSearch\QueryEndpoints\Search;
use ES\Kernel\ElasticSearch\QueryEndpoints\Select;
use ES\Kernel\Helper\Util;

class ElasticResultFactory
{
    /**
     * @param string $response
     * @param ElasticSearch $elasticSearchNew
     * @return AbstractResponse
     * @throws \ES\Kernel\Exception\ObjectException
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
                return new DefaultResponse($response);
        }
	}

    /**
     * @param string $response
     * @return bool
     */
	private static function hasError(string $response): bool
    {
    	$response = Util::jsonDecode($response);

        return !empty($response['error']) || !empty($response['errors']);
    }
}