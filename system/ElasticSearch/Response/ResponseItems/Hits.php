<?php

namespace ElasticSearch\Response\ResponseItems;

use ObjectMapper\ClassToMappingInterface;

class Hits implements ClassToMappingInterface
{
    private $maxScope;
    private $total;
    private $hitsItemList;

    /**
     * Hits constructor.
     */
    public function __construct()
    {
        $this->hitsItemList = new HitsItemList();
    }

    /**
     * @return array
     */
    public function getProperties(): array
    {
       return [
            'maxScope',
            'total',
       ];
    }

    /**
     * @return mixed
     */
    public function getMaxScope()
    {
        return $this->maxScope;
    }

    /**
     * @param mixed $maxScope
     */
    public function setMaxScope($maxScope): void
    {
        $this->maxScope = $maxScope;
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
    public function getHitsItemList()
    {
        return $this->hitsItemList;
    }
}