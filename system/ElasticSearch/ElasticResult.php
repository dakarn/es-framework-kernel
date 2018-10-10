<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 12.03.2018
 * Time: 20:49
 */

namespace ElasticSearch;

class ElasticResult
{
	/**
	 * @var mixed
	 */
	private $response;

	/**
	 * ElasticResult constructor.
	 * @param string $response
	 */
	public function __construct(string $response)
	{
		$this->response = \json_decode($response, true);
		return $this;
	}

	/**
	 * @return array
	 */
	public function getResult(): array
	{
		return $this->response;
	}

	/**
	 * @return bool
	 */
	public function isSuccess(): bool
	{
		if (!isset($this->response['error'])) {
			return true;
		}

		return false;
	}

	/**
	 * @return bool
	 */
	public function isFailure(): bool
	{
		if (isset($this->response['error'])) {
			return true;
		}

		return false;
	}

	/**
	 * @return array
	 */
	public function getSource(): array
	{
		if (isset($this->response['_source'])) {
			return $this->response['_source'];
		}

		return [];
	}

	/**
	 * @return int
	 */
	public function getCount(): int
	{
		if (isset($this->response['hits']['total'])) {
			return $this->response['hits']['total'];
		}

		return 0;
	}

	/**
	 * @return string
	 */
	public function getStatus(): string
	{
		return $this->response['status'] ?? '';
	}

	/**
	 * @return array
	 */
	public function getError(): array
	{
		return $this->response['error'] ?? [];
	}
}