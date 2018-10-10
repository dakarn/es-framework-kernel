<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 01.05.2018
 * Time: 19:00
 */

namespace QueueManager\Senders;

use Configs\Config;
use RedisQueue\RedisQueue;
use QueueManager\QueueModel;
use RedisQueue\Queue as QueueMy;
use RedisQueue\RedisQueueInterface;

class RedisQueueSender implements QueueSenderInterface
{
	/**
	 * @var QueueModel
	 */
	private $params;

	/**
	 * @var array|mixed|string
	 */
	private $configConnect = [];

	/**
	 * @var RedisQueue
	 */
	private $queueRedis;

	/**
	 * RedisQueueSender constructor.
	 * @throws \Exception\FileException
	 */
	public function __construct()
	{
		$this->configConnect = Config::get('redis-queue');
	}

	/**
	 * @param QueueModel $params
	 * @return QueueSenderInterface
	 */
	public function setParams(QueueModel $params): QueueSenderInterface
	{
		$this->params = $params;
		return $this;
	}

	/**
	 * @return QueueSenderInterface
	 * @throws \RedisException
	 */
	public function build(): QueueSenderInterface
	{
		if ($this->queueRedis instanceof RedisQueueInterface) {
			return $this;
		}

		$this->queueRedis = new RedisQueue($this->configConnect['host'], $this->configConnect['port']);

		$queue = new QueueMy();
		$queue->setName($this->params->getName());

		$this->queueRedis->setQueueParam($queue);

		return $this;
	}

	/**
	 * @param string $data
	 * @return QueueSenderInterface
	 */
	public function setDataForSend(string $data): QueueSenderInterface
	{
		$this->params->setData($data);
		return $this;
	}

	/**
	 * @param bool $isClose
	 * @return int
	 * @throws \Exception
	 */
	public function send(bool $isClose = false): int
	{
		$answer = $this->queueRedis->client()->publish($this->params->getData());

		if ($isClose) {
			$this->queueRedis->disconnect();
		}

		return $answer;
	}

	/**
	 * @return string
	 */
	public function getResult(): string
	{
		return $this->queueRedis->client()->getResult();
	}

	/**
	 * @return void
	 */
	public function disconnect(): void
	{
		$this->queueRedis->disconnect();
	}
}