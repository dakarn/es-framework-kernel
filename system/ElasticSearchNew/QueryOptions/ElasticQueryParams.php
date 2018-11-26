<?php
/**
 * Created by PhpStorm.
 * User: v.konovalov
 * Date: 23.11.2018
 * Time: 15:41
 */

namespace ElasticSearchNew\QueryOptions;

use ElasticSearchNew\ElasticConnection;
use ElasticSearchNew\QueryTypes\RequestOperationInterface;

abstract class ElasticQueryParams implements ElasticQueryParamsInterface, RequestOperationInterface
{
    /**
     * @var HttpQuery
     */
    protected $httpQuery;

    /**
     * @var string
     */
    protected $index = '';

    /**
     * @var string
     */
    protected $type = '';

    /**
     * @var array
     */
    protected $query = [];

    /**
     * @var string
     */
    protected $id = '';

	/**
	 * @var string
	 */
    protected $queryStringURI = '';

    /**
     * @var bool
     */
    protected $isPretty = true;

	/**
	 * @return string
	 */
	public function getQueryStringURI(): string
	{
		return $this->queryStringURI;
	}

	/**
	 * @param string $queryStringURI
	 */
	public function setQueryStringURI(string $queryStringURI): void
	{
		$this->queryStringURI = $queryStringURI;
	}

    /**
     * @return string
     */
    public function getIndex(): string
    {
        return $this->index;
    }

    /**
     * @return array
     */
    public function getQuery(): array
    {
        return $this->query;
    }

    /**
     * @return bool
     */
    public function isPretty(): bool
    {
        return $this->isPretty;
    }

    /**
     * @param bool $isPretty
     * @return ElasticQueryParams
     */
    public function setPretty(bool $isPretty): RequestOperationInterface
    {
        $this->isPretty = $isPretty;

        return $this;
    }

    /**
     * @param array $query
     * @return ElasticQueryParams
     */
    public function setQuery(array $query): RequestOperationInterface
    {
        $this->query = $query;

        return $this;
    }

    /**
     * @param string $index
     * @return ElasticQueryParams
     */
    public function setIndex(string $index): RequestOperationInterface
    {
        $this->index = $index;

        return $this;
    }

    /**
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * @param string $type
     * @return ElasticQueryParams
     */
    public function setType(string $type): RequestOperationInterface
    {
        $this->type = $type;

        return $this;
    }

    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * @param string $id
     * @return ElasticQueryParams
     */
    public function setId(string $id): RequestOperationInterface
    {
        $this->id = $id;

        return $this;
    }

    /**
     * @param ElasticConnection $elasticConnect
     * @return HttpQuery
     */
    abstract public function buildParams(ElasticConnection $elasticConnect): HttpQuery;
}