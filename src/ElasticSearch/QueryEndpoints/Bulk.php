<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 26.11.2018
 * Time: 21:21
 */

namespace ElasticSearch\QueryEndpoints;

use ElasticSearch\ElasticConnection;
use ElasticSearch\QueryOptions\ElasticQueryParams;
use ElasticSearch\QueryOptions\HttpCommandsInterface;
use ElasticSearch\QueryOptions\HttpQuery;
use Http\Request\Request;

class Bulk extends ElasticQueryParams
{
	/**
	 * @var string
	 */
	private $bulkData = '';

    /**
     * @param ElasticConnection $elasticConnect
     * @return HttpQuery
     */
	public function buildQuery(ElasticConnection $elasticConnect): HttpQuery
	{
		$host = $this->makeHost($elasticConnect);

		$this->httpQuery->setUrl($host . HttpCommandsInterface::BULK);
		$this->httpQuery->setMethod(Request::POST);
		$this->httpQuery->setQueryString($this->bulkData);

		return $this->httpQuery;
	}

	/**
	 * @param array $data
	 * @return Bulk
	 */
	public function setBulkArray(array $data): self
	{
		$this->bulkData = $this->arrayToBulkString($data);

		return $this;
	}

	/**
	 * @param string $data
	 * @return Bulk
	 */
	public function setBulkString(string $data): self
	{
		$this->bulkData = $data;

		return $this;
	}

    /**
     * @param array $bulkData
     * @return string
     */
	private function arrayToBulkString(array $bulkData): string
	{
		$retData = '';

		foreach ($bulkData as  $itemArray) {
            $retData .= \json_encode($itemArray, JSON_UNESCAPED_UNICODE) . \PHP_EOL;
		}

		return $retData;
	}
}