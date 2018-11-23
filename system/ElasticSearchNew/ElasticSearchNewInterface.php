<?php
/**
 * Created by PhpStorm.
 * User: v.konovalov
 * Date: 23.11.2018
 * Time: 17:35
 */

namespace ElasticSearchNew;

interface ElasticSearchNewInterface
{
    /**
     * @return ElasticQueryParams
     */
    public function select(): ElasticQueryParams;

    /**
     * @return ElasticQueryParams
     */
    public function index(): ElasticQueryParams;

    /**
     * @return ElasticQueryParams
     */
    public function update(): ElasticQueryParams;

    /**
     * @return ElasticQueryParams
     */
    public function remove(): ElasticQueryParams;

    /**
     * @return ElasticQueryParams
     */
    public function insert(): ElasticQueryParams;

    /**
     * @return ElasticQueryParams
     */
    public function getCurrentQueryType(): ElasticQueryParams;
}