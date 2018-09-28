<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 02.04.2018
 * Time: 16:38
 */

namespace QueueManager\Senders;

use Configs\Config;
use QueueManager\QueueModel;

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
	 * @var QueueModel
	 */
	private $params;

	/**
	 * RabbitQueueSender constructor.
	 */
	public function __construct()
	{
		$this->configConnect = Config::get('rabbit');
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
	public function setDataForSend(string $data): QueueSenderInterface
	{
		$this->params->setData($data);
		return $this;
	}

	/**
	 * @param bool $isClose
	 * @return bool
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