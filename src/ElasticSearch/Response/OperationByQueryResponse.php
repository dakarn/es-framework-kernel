<?php

namespace ElasticSearch\Response;

use ObjectMapper\ClassToMappingInterface;

final class OperationByQueryResponse extends AbstractResponse implements ClassToMappingInterface
{
    private $took;
    private $timedOut;
    private $deleted;
    private $updated;
    private $batches;
    private $versionConflicts;
    private $noops;
    private $retries;
    private $throttled_millis;
    private $requests_per_second;
    private $throttled_until_millis;
    private $total;
    private $failures;

    /**
     * @return array
     */
    public function getProperties(): array
    {
        return [
            'took',
            'timedOut',
            'deleted',
            'updated',
            'batches',
            'versionConflicts',
            'noops',
            'retries',
            'throttled_millis',
            'requests_per_second',
            'throttled_until_millis',
            'total',
            'failures',
        ];
    }

    /**
     * @return mixed
     */
    public function getTook():? int
    {
        return $this->took;
    }

    /**
     * @param mixed $took
     */
    public function setTook($took): void
    {
        $this->took = $took;
    }

    /**
     * @return mixed
     */
    public function getTimedOut():? bool
    {
        return $this->timedOut;
    }

    /**
     * @param mixed $timedOut
     */
    public function setTimedOut($timedOut): void
    {
        $this->timedOut = $timedOut;
    }

    /**
     * @return mixed
     */
    public function getDeleted()
    {
        return $this->deleted;
    }

    /**
     * @param mixed $deleted
     */
    public function setDeleted($deleted): void
    {
        $this->deleted = $deleted;
    }

    /**
     * @return mixed
     */
    public function getUpdated()
    {
        return $this->updated;
    }

    /**
     * @param mixed $updated
     */
    public function setUpdated($updated): void
    {
        $this->updated = $updated;
    }

    /**
     * @return mixed
     */
    public function getBatches()
    {
        return $this->batches;
    }

    /**
     * @param mixed $batches
     */
    public function setBatches($batches): void
    {
        $this->batches = $batches;
    }

    /**
     * @return mixed
     */
    public function getVersionConflicts()
    {
        return $this->versionConflicts;
    }

    /**
     * @param mixed $versionConflicts
     */
    public function setVersionConflicts($versionConflicts): void
    {
        $this->versionConflicts = $versionConflicts;
    }

    /**
     * @return mixed
     */
    public function getNoops()
    {
        return $this->noops;
    }

    /**
     * @param mixed $noops
     */
    public function setNoops($noops): void
    {
        $this->noops = $noops;
    }

    /**
     * @return mixed
     */
    public function getRetries()
    {
        return $this->retries;
    }

    /**
     * @param mixed $retries
     */
    public function setRetries($retries): void
    {
        $this->retries = $retries;
    }

    /**
     * @return mixed
     */
    public function getThrottledMillis()
    {
        return $this->throttled_millis;
    }

    /**
     * @param mixed $throttled_millis
     */
    public function setThrottledMillis($throttled_millis): void
    {
        $this->throttled_millis = $throttled_millis;
    }

    /**
     * @return mixed
     */
    public function getRequestsPerSecond()
    {
        return $this->requests_per_second;
    }

    /**
     * @param mixed $requests_per_second
     */
    public function setRequestsPerSecond($requests_per_second): void
    {
        $this->requests_per_second = $requests_per_second;
    }

    /**
     * @return mixed
     */
    public function getThrottledUntilMillis()
    {
        return $this->throttled_until_millis;
    }

    /**
     * @param mixed $throttled_until_millis
     */
    public function setThrottledUntilMillis($throttled_until_millis): void
    {
        $this->throttled_until_millis = $throttled_until_millis;
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
    public function getFailures()
    {
        return $this->failures;
    }

    /**
     * @param mixed $failures
     */
    public function setFailures($failures): void
    {
        $this->failures = $failures;
    }
}