<?php
/**
 * Created by PhpStorm.
 * User: v.konovalov
 * Date: 23.11.2018
 * Time: 15:41
 */

namespace ElasticSearchNew;

abstract class ElasticQueryParams implements ElasticQueryParamsInterface
{
    /**
     * @var string
     */
    private $index = '';

    /**
     * @var string
     */
    private $type = '';

    /**
     * @var array
     */
    private $query = [];

    /**
     * @var string
     */
    private $id = '';

    /**
     * @var bool
     */
    private $isPretty = true;

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
    public function setIsPretty(bool $isPretty): ElasticQueryParams
    {
        $this->isPretty = $isPretty;

        return $this;
    }

    /**
     * @param array $query
     * @return ElasticQueryParams
     */
    public function setQuery(array $query): ElasticQueryParams
    {
        $this->query = $query;

        return $this;
    }

    /**
     * @param string $index
     * @return ElasticQueryParams
     */
    public function setIndex(string $index): ElasticQueryParams
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
    public function setType(string $type): ElasticQueryParams
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
    public function setId(string $id): ElasticQueryParams
    {
        $this->id = $id;

        return $this;
    }

    abstract function buildParams();
}