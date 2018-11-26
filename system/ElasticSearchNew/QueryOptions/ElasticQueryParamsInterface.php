<?php
/**
 * Created by PhpStorm.
 * User: v.konovalov
 * Date: 23.11.2018
 * Time: 15:47
 */

namespace ElasticSearchNew\QueryOptions;

use ElasticSearchNew\QueryEndpoints\RequestOperationInterface;

interface ElasticQueryParamsInterface
{
    /**
     * @return string
     */
    public function getIndex(): string;

    /**
     * @param string $index
     * @return ElasticQueryParams
     */
    public function setIndex(string $index): RequestOperationInterface;

    /**
     * @return string
     */
    public function getType(): string;

    /**
     * @param string $type
     * @return ElasticQueryParams
     */
    public function setType(string $type): RequestOperationInterface;

    /**
     * @return string
     */
    public function getId(): string;

    /**
     * @param string $id
     * @return ElasticQueryParams
     */
    public function setId(string $id): RequestOperationInterface;
}