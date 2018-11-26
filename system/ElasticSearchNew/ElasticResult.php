<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 12.03.2018
 * Time: 20:49
 */

namespace ElasticSearchNew;

class ElasticResult implements ElasticResultInterface
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

	public function isFound(): bool
    {
        return isset($this->response['found']) && $this->response['found'] == true;
    }

	/**
	 * @return array
	 */
	public function getResponse(): array
	{
		return $this->response;
	}

    /**
     * @return string
     */
	public function getResult(): string
    {
        return $this->response['result'] ?? '';
    }

    /**
     * @return array
     */
    public function getRecords(): array
    {
        $data = [];

        if (isset($this->response['hits'])) {
            foreach ($this->response['hits']['hits'] as $valueHit) {
                $data[$valueHit['_id']] = $valueHit['_source'];
            }
        }

        return $data;
    }

    /**
     * @return array
     */
    public function getRecord(): array
    {
        $data = [];

        if (isset($this->response['_source'])) {
            foreach ($this->response['_source'] as $indexSource => $valueSource) {
                return [$indexSource=> $valueSource];
            }
        }

        return $data;
    }

    /**
     * @param $objectList
     * @param $object
     */
    public function getRecordsAsObject($objectList, $object)
    {

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
	public function getCountRecords(): int
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

    /**
     * @return array
     */
	public function getShards(): array
    {
        return $this->response['_shards'] ?? [];
    }

    /**
     * @return int
     */
	public function getVersion(): int
    {
        return $this->response['_version'] ?? 0;
    }


}