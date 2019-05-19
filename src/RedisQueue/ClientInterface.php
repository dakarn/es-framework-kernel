<?php

namespace ES\Kernel\RedisQueue;

interface ClientInterface
{
    /**
     * ClientInterface constructor.
     * @param \Redis $redis
     * @param RedisQueue $redisQueue
     */
    public function __construct(\Redis $redis, RedisQueue $redisQueue);

    /**
     * @param string $msg
     * @return int
     */
    public function publish(string $msg): int;

    /**
     * @param int $timeout
     * @return string
     */
    public function getResult(int $timeout = 5): string;
}