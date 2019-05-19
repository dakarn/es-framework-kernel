<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 02.05.2018
 * Time: 23:11
 */

namespace ES\Kernel\RedisQueue;

class Client implements ClientInterface
{
    /**
     * @var string
     */
    const FORMAT_SEND = '{"hash": "%s", "data": %s}';

    /**
     * @var int
     */
    const TIME_SLEEP = 100;

    /**
     * @var \Redis
     */
    private $redis;

    /**
     * @var
     */
    private $idHash;

    /**
     * @var RedisQueue
     */
    private $redisQueue;

    /**
     * Client constructor.
     * @param \Redis $redis
     * @param RedisQueue $redisQueue
     */
    public function __construct(\Redis $redis, RedisQueue $redisQueue)
	{
        $this->redisQueue = $redisQueue;
        $this->redis      = $redis;
	}

	/**
	 * @param string $msg
	 * @return int
	 * @throws \Exception
	 */
    public function publish(string $msg): int
	{
		return $this->redis->rPush($this->redisQueue->getQueueParam()->getName(), $this->generateData($msg));
	}

    /**
     * @param int $timeout
     * @return string
     */
    public function getResult(int $timeout = 5): string
	{
		$currentTime = 0;
		$timeout     = $timeout * 100000;

		while (true) {

			if ($currentTime >= $timeout) {
				return '';
			}

			$value = $this->redis->get($this->idHash);

			if ($value !== false) {
				return $value;
			}

			$currentTime += self::TIME_SLEEP;
			\usleep(self::TIME_SLEEP);
		}

		return '';
	}

	/**
	 * @param string $msg
	 * @return string
	 * @throws \Exception
	 */
    private function generateData(string $msg): string
	{
		$this->idHash = microtime(true) . \random_int(1, 10000);
		return \sprintf(self::FORMAT_SEND, $this->idHash, $msg);
	}
}