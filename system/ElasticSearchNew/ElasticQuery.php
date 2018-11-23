<?php
/**
 * Created by PhpStorm.
 * User: v.konovalov
 * Date: 23.11.2018
 * Time: 15:46
 */

namespace ElasticSearchNew;

use Traits\SingletonTrait;

class ElasticQuery
{
    use SingletonTrait;

    private $elasticQueryParams;

    public function execute(ElasticQueryParams $elasticQueryParams): ElasticResult
    {
        $this->elasticQueryParams = $elasticQueryParams;

        $this->buildRequest();

        return new ElasticResult('');
    }

    private function buildRequest()
    {

    }

    private function doRequest()
    {

    }
}