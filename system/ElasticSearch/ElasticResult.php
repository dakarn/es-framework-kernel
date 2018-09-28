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
	private $response;

	public function __construct(string $response)
	{
		$this->response = json_decode($response, true);
		return $this;
	}

	public function getResult(): array
	{
		return $this->response;
	}

	public function isSuccess(): bool
	{
		if (!isset($this->response['error'])) {
			return true;
		}

		return false;
	}

	public function isFailure(): bool
	{
		if (isset($this->response['error'])) {
			return true;
		}

		return false;
	}

	public function getSource(): array
	{
		if (isset($this->response['_source'])) {
			return $this->response['_source'];
		}

		return [];
	}

	public function getCount(): int
	{
		if (isset($this->response['hits']['total'])) {
			return $this->response['hits']['total'];
		}

		return 0;
	}

	public function getStatus(): string
	{
		return $this->response['status'] ?? '';
	}

	public function getError(): array
	{
		return $this->response['error'] ?? [];
	}
}