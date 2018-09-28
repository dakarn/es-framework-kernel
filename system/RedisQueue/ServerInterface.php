<?php

namespace RedisQueue;

interface ServerInterface
{
    /**
     * Server constructor.
     * @param \Redis $redis
     * @param RedisQueue $redisQueue
     */
    public function __construct(\Redis $redis, RedisQueue $redisQueue);

    /**
     * @param string $status
     */
    public function sendStatusTask(string $status): void;

    /**
     * @return bool
     */
    public function isDoWork(): bool;

    /**
     * @param int $pause
     */
    public function pause(int $pause = 1000000): void;

    /**
     * @return $this
     */
    public function setWorkDone();

    /**
     * @return $this
     */
    public function setWorkProcess();

    /**
     * @return OutputResult
     */
    public function sendResult();

    /**
     * @return QueueEnvelope
     */
    public function getStack(): QueueEnvelope;
}