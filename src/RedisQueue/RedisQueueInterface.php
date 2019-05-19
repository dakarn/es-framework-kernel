<?php

namespace ES\Kernel\RedisQueue;

interface RedisQueueInterface
{
    /**
     * RedisQueueInterface constructor.
     * @param string $host
     * @param int $port
     * @param string $password
     */
    public function __construct(string $host, int $port, string $password = '');

    /**
     * @return Client
     */
    public function client(): Client;

    /**
     * @return Server
     */
    public function server(): Server;

    /**
     * @param Queue $queue
     * @return RedisQueue
     */
    public function setQueueParam(Queue $queue): RedisQueue;

    /**
     * @return Queue
     */
    public function getQueueParam(): Queue;

    /**
     *
     */
    public function disconnect(): void;
}