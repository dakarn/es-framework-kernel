<?php
/**
 * Created by PhpStorm.
 * User: v.konovalov
 * Date: 23.11.2018
 * Time: 16:57
 */

namespace ES\Kernel\ElasticSearch\QueryEndpoints;

use ES\Kernel\ElasticSearch\ElasticConnection;
use ES\Kernel\ElasticSearch\QueryOptions\ElasticQueryParams;
use ES\Kernel\ElasticSearch\QueryOptions\HttpCommandsInterface;
use ES\Kernel\ElasticSearch\QueryOptions\HttpQuery;
use ES\Kernel\Http\Request\Request;

class Index extends ElasticQueryParams
{
    private const CREATE  = 'create';
    private const REMOVE  = 'remove';
    private const MAPPING = 'mapping';
    private const REINDEX = 'reindex';

    /**
     * @var array
     */
    private $mappings = [];

    /**
     * @var string
     */
    private $command = '';

    /**
     * @param ElasticConnection $elasticConnect
     * @return HttpQuery
     */
    public function buildQuery(ElasticConnection $elasticConnect): HttpQuery
    {
        $host     = $this->makeHost($elasticConnect);
	    $pathname = $this->index;


        switch ($this->command) {
            case self::CREATE:
                $this->appendCreate();
                break;
            case self::REMOVE:
                $this->appendRemove();
                break;
            case self::REINDEX:
                $pathname = $this->appendReindex();
                break;
            case self::MAPPING:
                $this->appendMapping();
                break;
        }

        $this->httpQuery->setUrl($host . $pathname);

        return $this->httpQuery;
    }

	/**
	 * @param array $data
	 * @return Index
	 */
    public function withMapping(array $data): Index
    {
        $this->mappings = $data;

        return $this;
    }

	/**
	 * @return Index
	 */
    public function create(): Index
    {
        $this->command = self::CREATE;
        return $this;
    }

	/**
	 * @return Index
	 */
    public function remove(): Index
    {
        $this->command = self::REMOVE;
        return $this;
    }

    /**
     * @return Index
     */
    private function appendCreate(): Index
    {
        $this->httpQuery->setMethod(Request::PUT);

        if (!empty($this->mappings)) {
            $this->httpQuery->setQueryArray($this->mappings);
        }

        return $this;
    }

    /**
     * @return Index
     */
    private function appendRemove(): Index
    {
        $this->httpQuery->setMethod(Request::DELETE);

        return $this;
    }

    /**
     * @return Index
     */
    private function appendMapping(): Index
    {
        return $this;
    }

    /**
     * @return string
     */
    private function appendReindex(): string
    {
        $this->httpQuery->setMethod(Request::POST);

        return HttpCommandsInterface::REINDEX;
    }
}