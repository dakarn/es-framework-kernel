<?php
/**
 * Created by PhpStorm.
 * User: v.konovalov
 * Date: 23.11.2018
 * Time: 15:41
 */

namespace ElasticSearchNew;

abstract class AbstractElasticQueryParams extends AbstractElasticQuery implements ElasticQueryParamsInterface
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
     * @return AbstractElasticQueryParams
     */
    public function setIsPretty(bool $isPretty): AbstractElasticQueryParams
    {
        $this->isPretty = $isPretty;

        return $this;
    }

    /**
     * @param array $query
     * @return AbstractElasticQueryParams
     */
    public function setQuery(array $query): AbstractElasticQueryParams
    {
        $this->query = $query;

        return $this;
    }

    /**
     * @param string $index
     * @return AbstractElasticQueryParams
     */
    public function setIndex(string $index): AbstractElasticQueryParams
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
     * @return AbstractElasticQueryParams
     */
    public function setType(string $type): AbstractElasticQueryParams
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
     * @return AbstractElasticQueryParams
     */
    public function setId(string $id): AbstractElasticQueryParams
    {
        $this->id = $id;

        return $this;
    }

    abstract function buildParams();
}