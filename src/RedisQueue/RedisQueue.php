<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 30.04.2018
 * Time: 15:09
 */

namespace ES\Kernel\RedisQueue;

class RedisQueue implements RedisQueueInterface
{
    /**
     * @var int
     */
    const MAX_TRY_RECONNECT = 3;

    /**
     * @var string
     */
    const REQUEUE = 'requeue';

    /**
     * @var string
     */
    const QUEUE_DELETE = 'queueDelete';

	/**
	 * @var \Redis
	 */
	private $redis;

	/**
	 * @var Queue
	 */
	private $queue;

	/**
	 * @var Client
	 */
	private $client;

	/**
	 * @var Server
	 */
	private $server;

    /**
     * RedisQueue constructor.
     * @param string $host
     * @param int $port
     * @param string $password
     * @throws \RedisException
     */
	public function __construct(string $host, int $port, string $password = '')
	{
		try {
			$this->redis = new \Redis();

			if (!$this->redis->connect($host, $port)) {
			    $this->reConnect($host, $port, $password);
            }

            $this->redis->auth($password);

			$this->client   = new Client($this->redis, $this);
			$this->server   = new Server($this->redis, $this);
		} catch (\RedisException $e) {
			throw $e;
		}
	}

    /**
     * @return Client
     */
    public function client(): Client
    {
        return $this->client;
    }

    /**
     * @return Server
     */
    public function server(): Server
    {
        return $this->server;
    }

	/**
	 * @param Queue $queue
	 * @return RedisQueue
	 */
	public function setQueueParam(Queue $queue): RedisQueue
	{
		$this->queue = $queue;
		return $this;
	}

    /**
     * @return Queue
     */
    public function getQueueParam(): Queue
    {
        return $this->queue;
    }

	/**
	 * @return void
	 */
	public function disconnect(): void
	{
		if ($this->redis instanceof \Redis) {
			$this->redis->close();
		}
	}

    /**
     * @param string $host
     * @param string $port
     * @param string $password
     */
	private function reConnect(string $host, string $port, string $password): void
    {
        \sleep(2);

        if (!$this->redis->connect($host, $port)) {
            throw new \RuntimeException('Redis Server on "' . $host . ':' . $port . '" gone away!');
        }
    }
}