<?php
/**
 * Created by PhpStorm.
 * User: v.konovalov
 * Date: 23.11.2018
 * Time: 15:46
 */

namespace ElasticSearchNew;

abstract class AbstractElasticQuery
{
    public function execute(): ElasticResult
    {
        return new ElasticResult('');
    }
}