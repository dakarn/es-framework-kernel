<?php
/**
 * Created by PhpStorm.
 * User: v.konovalov
 * Date: 23.11.2018
 * Time: 15:41
 */

namespace ElasticSearch\QueryOptions;

use ElasticSearch\ElasticConnection;

abstract class ElasticQueryParams
{
    /**
     * @var bool
     */
    private $isUseByQuery = false;

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
	 * @var array
	 */
    protected $customQuery = [];

    /**
     * ElasticQueryParams constructor.
     */
    public function __construct()
    {
        $this->httpQuery = new HttpQuery();
    }

    /**
     * @param bool $isUseByQuery
     */
    public function setIsUseByQuery(bool $isUseByQuery): void
    {
        $this->isUseByQuery = $isUseByQuery;
    }

    /**
     * @return bool
     */
    public function isUseByQuery(): bool
    {
        return $this->isUseByQuery;
    }

	/**
	 * @return array
	 */
	public function getCustomQuery(): array
	{
		return $this->customQuery;
	}

	/**
	 * @param string $path
	 * @param string $method
	 * @param array $query
	 * @return ElasticQueryParams
	 */
	public function setCustomQuery(string $path, string $method, array $query): self
	{
		$this->customQuery['path']   = $path;
		$this->customQuery['method'] = $method;
		$this->customQuery['query']  = $query;

		return $this;
	}

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
    public function setPretty(bool $isPretty): self
    {
        $this->isPretty = $isPretty;

        return $this;
    }

    /**
     * @param array $query
     * @return ElasticQueryParams
     */
    public function setQuery(array $query): self
    {
        $this->query = $query;

        return $this;
    }

    /**
     * @param string $index
     * @return ElasticQueryParams
     */
    public function setIndex(string $index): self
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
    public function setType(string $type): self
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
    public function setId(string $id): self
    {
        $this->id = $id;

        return $this;
    }

    /**
     * @param ElasticConnection $connect
     * @return string
     */
    protected function makeHost(ElasticConnection $connect): string
    {
    	return $connect->getSchema() . '://' . $connect->getHost() . ':' . $connect->getPort() . '/';
    }

    /**
     * @param ElasticConnection $elasticConnect
     * @return HttpQuery
     */
    abstract public function buildQuery(ElasticConnection $elasticConnect): HttpQuery;
}