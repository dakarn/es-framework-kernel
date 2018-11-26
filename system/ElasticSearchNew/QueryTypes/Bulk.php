<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 26.11.2018
 * Time: 21:21
 */

namespace ElasticSearchNew\QueryTypes;

use ElasticSearchNew\ElasticConnection;
use ElasticSearchNew\QueryOptions\ElasticQueryParams;
use ElasticSearchNew\QueryOptions\HttpCommandsInterface;
use ElasticSearchNew\QueryOptions\HttpQuery;
use Http\Request\Request;

class Bulk extends ElasticQueryParams
{
	/**
	 * @var array
	 */
	private $bulkData = [];

	/**
	 * @param ElasticConnection $connect
	 * @return HttpQuery
	 */
	public function buildParams(ElasticConnection $connect): HttpQuery
	{
		$this->httpQuery = new HttpQuery();

		$pathname = HttpCommandsInterface::BULK;
		$host     = $connect->getSchema() . '://' . $connect->getHost() . ':' . $connect->getPort() . '/';

		$this->httpQuery->setUrl($host . $pathname);
		$this->httpQuery->setMethod(Request::POST);
		$this->httpQuery->setQueryString($this->arrayToBulkString());

		return $this->httpQuery;
	}

	/**
	 * @param array $data
	 * @return ElasticQueryParams
	 */
	public function setBulkData(array $data): ElasticQueryParams
	{
		$this->bulkData = $data;

		return $this;
	}

	/**
	 * @return string
	 */
	private function arrayToBulkString(): string
	{
		$retData = '';

		foreach ($this->bulkData as $index => $value) {

			$header = [
				'_index' => $this->index,
				'_type' => $this->type
			];

			if (!empty($this->id)) {
				$header = $header + ['_id' => $this->id];
			}

			$retData .= \json_encode([
					'index' => $header,
				], JSON_UNESCAPED_UNICODE) . \PHP_EOL;


			$retData .= \json_encode([
					'word'   => 'fdfdf',
				], JSON_UNESCAPED_UNICODE) . \PHP_EOL;

		}

		return $retData;
	}
}