<?php
/**
 * Created by PhpStorm.
 * User: v.konovalov
 * Date: 23.11.2018
 * Time: 15:47
 */

namespace ElasticSearchNew;

interface ElasticQueryParamsInterface
{
    /**
     * @return string
     */
    public function getIndex(): string;

    /**
     * @param string $index
     * @return AbstractElasticQueryParams
     */
    public function setIndex(string $index): AbstractElasticQueryParams;

    /**
     * @return string
     */
    public function getType(): string;

    /**
     * @param string $type
     * @return AbstractElasticQueryParams
     */
    public function setType(string $type): AbstractElasticQueryParams;

    /**
     * @return string
     */
    public function getId(): string;

    /**
     * @param string $id
     * @return AbstractElasticQueryParams
     */
    public function setId(string $id): AbstractElasticQueryParams;
}