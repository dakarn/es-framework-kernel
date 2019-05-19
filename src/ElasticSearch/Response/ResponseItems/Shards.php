<?php

namespace ES\Kernel\ElasticSearch\Response\ResponseItems;

use ES\Kernel\ObjectMapper\ClassToMappingInterface;

class Shards implements ClassToMappingInterface
{
    private $total;
    private $successful;
    private $skipped;
    private $failed;

    /**
     * @return array
     */
    public function getProperties(): array
    {
        return [
            'total',
            'successful',
            'skipped',
            'failed',
        ];
    }

    /**
     * @return mixed
     */
    public function getTotal()
    {
        return $this->total;
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
    public function getSuccessful()
    {
        return $this->successful;
    }

    /**
     * @param mixed $successful
     */
    public function setSuccessful($successful): void
    {
        $this->successful = $successful;
    }

    /**
     * @return mixed
     */
    public function getSkipped()
    {
        return $this->skipped;
    }

    /**
     * @param mixed $skipped
     */
    public function setSkipped($skipped): void
    {
        $this->skipped = $skipped;
    }

    /**
     * @return mixed
     */
    public function getFailed()
    {
        return $this->failed;
    }

    /**
     * @param mixed $failed
     */
    public function setFailed($failed): void
    {
        $this->failed = $failed;
    }
}