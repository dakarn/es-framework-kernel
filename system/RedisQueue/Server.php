<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 02.05.2018
 * Time: 23:12
 */

namespace RedisQueue;

class Server implements ServerInterface
{
    /**
     * @var \Redis
     */
    private $redis;

    /**
     * @var
     */
    private $outputResult;

    /**
     * @var bool
     */
    private $isDoWork = false;

    /**
     * @var
     */
    private $idHash;

    /**
     * @var RedisQueue
     */
    private $redisQueue;

    /**
     * @var QueueEnvelope
     */
    private $envelope;

    /**
     * Server constructor.
     * @param \Redis $redis
     * @param RedisQueue $redisQueue
     */
    public function __construct(\Redis $redis, RedisQueue $redisQueue)
	{
	    $this->redisQueue = $redisQueue;
		$this->redis      = $redis;
		$this->envelope = new QueueEnvelope();
	}

    /**
     * @param string $status
     */
    public function sendStatusTask(string $status): void
	{
		$this->redis->set($this->idHash, $status);
	}

    /**
     * @return bool
     */
    public function isDoWork(): bool
	{
		return $this->isDoWork;
	}

    /**
     * @param int $pause
     */
    public function pause(int $pause = 1000000): void
	{
		usleep($pause);
	}

    /**
     * @return $this
     */
    public function setWorkDone()
	{
		$this->isDoWork = false;
		return $this;
	}

    /**
     * @return $this
     */
    public function setWorkProcess()
	{
		$this->isDoWork = true;
		return $this;
	}

    /**
     * @return OutputResult
     */
    public function sendResult()
	{
		if (!$this->outputResult instanceof OutputResult){
			$this->outputResult = new OutputResult($this);
		}

		return $this->outputResult;
	}

    /**
     * @return QueueEnvelope
     * @throws \RedisException
     */
    public function getStack(): QueueEnvelope
	{
	    try {
            if ($this->isDoWork) {
                return $this->envelope->setBody('');
            }

            $body = $this->redis->lPop($this->redisQueue->getQueueParam()->getName());

            if (!empty($body)) {
                $this->isDoWork = true;
            }

            $bodyJson     = json_decode($body, true);
            $this->idHash = $bodyJson['hash'];
            $this->envelope->setBody((string)$bodyJson['data']);

            return $this->envelope;
        } catch (\RedisException $e) {
            throw $e;
        }
	}
}