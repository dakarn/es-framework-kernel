<?php


namespace ES\Kernel\ElasticSearch\QueryEndpoints;

use ES\Kernel\ElasticSearch\ElasticConnection;
use ES\Kernel\ElasticSearch\QueryOptions\ElasticQueryParams;
use ES\Kernel\ElasticSearch\QueryOptions\HttpQuery;
use ES\Kernel\Helper\Mime;
use ES\Kernel\Http\Request\Request;

class Sql extends ElasticQueryParams
{
    private const PATHNAME = '/sql?format=';

    private $format = Mime::EXT_JSON;

    /**
     * @param ElasticConnection $elasticConnect
     * @return HttpQuery
     */
    public function buildQuery(ElasticConnection $elasticConnect): HttpQuery
    {
        $host     = $this->makeHost($elasticConnect);
        $pathname = self::PATHNAME . $this->format;

        $this->httpQuery->setUrl($host . $pathname);
        $this->httpQuery->setMethod(Request::POST);
        $this->httpQuery->setQueryArray($this->query);

        return $this->httpQuery;
    }

    /**
     * @param string $format
     * @return Sql
     */
    public function setFormatResponse(string $format): self
    {
        $this->format = $format;

        return $this;
    }
}