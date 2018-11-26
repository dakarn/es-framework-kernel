<?php
/**
 * Created by PhpStorm.
 * User: v.konovalov
 * Date: 23.11.2018
 * Time: 15:45
 */

namespace ElasticSearchNew\QueryTypes;

use ElasticSearchNew\ElasticConnection;
use ElasticSearchNew\QueryOptions\ElasticQueryParams;
use ElasticSearchNew\QueryOptions\HttpCommandsInterface;
use ElasticSearchNew\QueryOptions\HttpQuery;
use Http\Request\Request;

class Insert extends ElasticQueryParams implements RequestOperationInterface
{
    /**
     * @var bool
     */
    private $isBulk = false;

    /**
     * @var array
     */
    private $bulkData = [];

    /**
     * @param ElasticConnection $connect
     * @return HttpQuery
     */
    public function buildParams(ElasticConnection $connect): HttpQuery
    {
        $httpQuery = new HttpQuery();

        $host = $connect->getSchema() . '://' . $connect->getHost() . ':' . $connect->getPort() . '/';

        if ($this->isBulk) {
            $pathname    = HttpCommandsInterface::BULK;
            $method      = Request::POST;
            $this->query = $this->convertArrayToBulkString();
        } else if (empty($this->id)) {
            $pathname = $this->index . '/' . $this->type . '/';
            $method   = Request::POST;
        } else {
            $pathname = $this->index . '/' . $this->type . '/' . $this->id;
            $method   = Request::PUT;
        }

        $httpQuery->setUrl($host . $pathname);
        $httpQuery->setMethod($method);
        $httpQuery->setQueryArray($this->query);

        return $httpQuery;
    }

    /**
     * @param array $data
     * @return ElasticQueryParams
     */
    public function setBulkData(array $data): ElasticQueryParams
    {
        $this->isBulk   = true;
        $this->bulkData = $data;

        return $this;
    }

    /**
     * @return string
     */
    private function convertArrayToBulkString(): string
    {
        $retData = '';

        foreach ($this->bulkData as $index => $value) {
            $retData = '';
        }

        return $retData;
    }
}