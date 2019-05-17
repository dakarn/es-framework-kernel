<?php

namespace ElasticSearch;

use ElasticSearch\QueryOptions\ElasticQueryParams;
use ElasticSearch\Response\AbstractResponse;
use Exception\HttpException;

interface ElasticQueryInterface
{
    /**
     * @param ElasticQueryParams $elasticQueryParams
     * @return AbstractResponse
     * @throws HttpException
     * @throws \Exception\FileException
     * @throws \Exception\ObjectException
     */
    public function execute(ElasticQueryParams $elasticQueryParams): AbstractResponse;
}