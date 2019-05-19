<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 02.04.2018
 * Time: 16:38
 */

namespace ES\Kernel\QueueManager\Senders;

use ES\Kernel\Configs\Config;
use ES\Kernel\QueueManager\QueueModelInterface;

class RabbitQueueSender implements QueueSenderInterface
{
	/**
	 * @var \AMQPConnection
	 */
	private $amqp;

	/**
	 * @var \AMQPExchange
	 */
	private $exchange;

	/**
	 * @var \AMQPChannel
	 */
	private $channel;

	/**
	 * @var \AMQPQueue
	 */
	private $queueInst;

	/**
	 * @var array
	 */
	private $configConnect = [];

	/**
	 * @var QueueModelInterface
	 */
	private $params;

	/**
	 * RabbitQueueSender constructor.
	 * @throws \ES\Kernel\Exception\FileException
	 */
	public function __construct()
	{
		$this->configConnect = Config::get('rabbit');
	}

	/**
	 * @param QueueModelInterface $params
	 * @return QueueSenderInterface
	 */
	public function setParams(QueueModelInterface $params): QueueSenderInterface
	{
		$this->params = $params;
		return $this;
	}

	/**
	 * @return QueueSenderInterface
	 * @throws \AMQPChannelException
	 * @throws \AMQPConnectionException
	 * @throws \AMQPExchangeException
	 * @throws \AMQPQueueException
	 */
	public function build(): QueueSenderInterface
	{
		if ($this->amqp instanceof \AMQPConnection) {
			return $this;
		}

		$this->amqp = new \AMQPConnection($this->configConnect);
		$this->amqp->connect();

		$this->channel = new \AMQPChannel($this->amqp);

		$this->exchange = new \AMQPExchange($this->channel);

		$this->exchange->setName($this->params->getExchangeName());
		$this->exchange->setType($this->params->getType());
		$this->exchange->declareExchange();

		$this->queueInst = new \AMQPQueue($this->channel);
		$this->queueInst->setName($this->params->getName());

		return $this;
	}

	/**
	 * @param string $data
	 * @return QueueSenderInterface
	 */
	public function setDataString(string $data): QueueSenderInterface
	{
		$this->params->setData($data);
		return $this;
	}

    /**
     * @param array $data
     * @return QueueSenderInterface
     */
	public function setDataArray(array $data): QueueSenderInterface
	{
		return $this;
	}

	/**
	 * @param bool $isClose
	 * @return bool|mixed
	 * @throws \AMQPChannelException
	 * @throws \AMQPConnectionException
	 * @throws \AMQPExchangeException
	 */
	public function send(bool $isClose = false)
	{
		$result = $this->exchange->publish($this->params->getData(), $this->params->getRoutingKey());

		if ($isClose) {
			$this->amqp->disconnect();
		}

		return $result;
	}

	/**
	 * @return void
	 */
	public function disconnect(): void
	{
		$this->amqp->disconnect();
	}
}