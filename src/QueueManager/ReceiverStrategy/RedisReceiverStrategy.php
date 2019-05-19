<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 01.05.2018
 * Time: 19:00
 */

namespace ES\Kernel\QueueManager\ReceiverStrategy;

use ES\Kernel\Configs\Config;
use ES\Kernel\QueueManager\QueueModelInterface;
use RedisQueue\Queue as QueueRedis;
use RedisQueue\RedisQueue;

class RedisReceiverStrategy implements ReceiverStrategyInterface
{
	/**
	 * @var QueueModelInterface
	 */
	private $params;

	/**
	 * @var RedisQueue
	 */
	private $queueRedis;

	/**
	 * @var array
	 */
	private $configConnect;

	/**
	 * RedisReceiverStrategy constructor.
	 * @throws \ES\Kernel\Exception\FileException
	 */
	public function __construct()
	{
		$this->configConnect = Config::get('redis-queue');
	}

	/**
	 * @param QueueModelInterface $params
	 * @return ReceiverStrategyInterface
	 */
	public function setParams(QueueModelInterface $params): ReceiverStrategyInterface
	{
		$this->params = $params;
		return $this;
	}

	/**
	 * @return $this|mixed
	 * @throws \RedisException
	 */
	public function build()
	{
		$this->queueRedis = new RedisQueue($this->configConnect['host'], $this->configConnect['port']);

		$queue = new QueueRedis();
		$queue->setName('testQueue');

		$this->queueRedis->setQueueParam($queue);

		return $this;
	}

	/**
	 * @return array
	 */
	public function getCreatedObject(): array
	{
		return [
			'redis' => $this->queueRedis,
		];
	}
}