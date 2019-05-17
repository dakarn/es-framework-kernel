<?php

namespace ElasticSearch\Response;

use ElasticSearch\Response\ResponseItems\Hits;
use ElasticSearch\Response\ResponseItems\Shards;
use ObjectMapper\ObjectMapper;

final class SearchResponse extends AbstractResponse
{
    /**
     * @var Hits
     */
    private $hits;
    private $shards;

    /**
     * SearchResponse constructor.
     * @param string $response
     * @throws \Exception\ObjectException
     */
    public function __construct(string $response)
    {
        parent::__construct($response);

	    $this->hits   = ObjectMapper::create()->arrayToObject($this->response['hits'], Hits::class);
        $this->shards = ObjectMapper::create()->arrayToObject($this->response['_shards'], Shards::class);

        $this->response = [];
    }

    /**
     * @return Hits
     */
    public function getHits(): Hits
    {
        return $this->hits;
    }

    /**
     * @return Shards
     */
    public function getShards(): Shards
    {
        return $this->shards;
    }

    /**
     * @return int
     */
    public function getCountRecords(): int
    {
        return $this->hits->getTotal();
    }
}