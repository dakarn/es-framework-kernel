<?php

namespace ElasticSearch\Response\ResponseItems;

use ObjectMapper\ClassToMappingInterface;

class Hits implements ClassToMappingInterface
{
    private $maxScore;
    private $total;
    private $hits;

    /**
     * Hits constructor.
     */
    public function __construct()
    {
        $this->hits = new HitsItemList();
    }

    /**
     * @return array
     */
    public function getProperties(): array
    {
       return [
            'maxScore',
            'total',
       ];
    }

    /**
     * @return mixed
     */
    public function getMaxScore()
    {
        return $this->maxScore;
    }

    /**
     * @param mixed $maxScore
     */
    public function setMaxScore($maxScore): void
    {
        $this->maxScore = $maxScore;
    }

    /**
     * @return int
     */
    public function getTotal():? int
    {
        return (int) $this->total;
    }

    /**
     * @param mixed $total
     */
    public function setTotal($total): void
    {
        $this->total = $total;
    }

    /**
     * @return mixed
     */
    public function getHits()
    {
        return $this->hits;
    }
}