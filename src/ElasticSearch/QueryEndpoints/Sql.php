<?php


namespace ElasticSearch\QueryEndpoints;

use ElasticSearch\ElasticConnection;
use ElasticSearch\QueryOptions\ElasticQueryParams;
use ElasticSearch\QueryOptions\HttpQuery;
use Helper\Mime;
use Http\Request\Request;

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