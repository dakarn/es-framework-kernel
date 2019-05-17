<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 01.04.2018
 * Time: 0:48
 */

namespace QueueManager\ReceiverStrategy;

use AMQPConnection;
use Configs\Config;
use QueueManager\QueueModelInterface;

class RabbitReceiverStrategy implements ReceiverStrategyInterface
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
	 * RabbitReceiverStrategy constructor.
	 * @throws \Exception\FileException
	 */
	public function __construct()
	{
		$this->configConnect = Config::get('rabbit');
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
	 * @throws \AMQPChannelException
	 * @throws \AMQPConnectionException
	 * @throws \AMQPExchangeException
	 * @throws \AMQPQueueException
	 */
	public function build()
	{
		if (!$this->params instanceof QueueModelInterface) {
			throw new \LogicException('Object data for connection with QueueServer do not filled!');
		}

		$this->connection()
			 ->createChannel()
			 ->createExchange()
			 ->createQueue();

		return $this;
	}

	/**
	 * @param \AMQPEnvelope $msg
	 * @throws \AMQPChannelException
	 * @throws \AMQPConnectionException
	 */
	public function sendSuccess(\AMQPEnvelope $msg)
	{
		$this->queueInst->ack($msg->getDeliveryTag());
	}

	/**
	 * @param \AMQPEnvelope $msg
	 * @throws \AMQPChannelException
	 * @throws \AMQPConnectionException
	 */
	public function sendFailed(\AMQPEnvelope $msg)
	{
		$this->queueInst->nack($msg->getDeliveryTag(), AMQP_REQUEUE);
	}

	/**
	 * @return array
	 */
	public function getCreatedObject(): array
	{
		return ['queue' => $this->queueInst];
	}

	/**
	 * @return RabbitReceiverStrategy
	 * @throws \AMQPConnectionException
	 */
	private function connection(): self
	{
        $this->amqp = new AMQPConnection($this->configConnect);
        $this->amqp->connect();

		return $this;
	}

	/**
	 * @return RabbitReceiverStrategy
	 * @throws \AMQPConnectionException
	 */
	private function createChannel(): self
	{
		$this->channel = new \AMQPChannel($this->amqp);
		return $this;
	}

	/**
	 * @return RabbitReceiverStrategy
	 * @throws \AMQPChannelException
	 * @throws \AMQPConnectionException
	 * @throws \AMQPExchangeException
	 */
	private function createExchange(): self
	{
		$this->exchange = new \AMQPExchange($this->channel);

		$this->exchange->setName($this->params->getExchangeName());
		$this->exchange->setType($this->params->getType());
		$this->exchange->declareExchange();

		return $this;
	}

	/**
	 * @return RabbitReceiverStrategy
	 * @throws \AMQPChannelException
	 * @throws \AMQPConnectionException
	 * @throws \AMQPQueueException
	 */
	private function createQueue(): self
	{
		$this->queueInst = new \AMQPQueue($this->channel);

		$this->queueInst->setName($this->params->getTopicName());
		$this->queueInst->declareQueue();
		$this->queueInst->bind($this->params->getExchangeName(), $this->params->getRoutingKey());

		return $this;
	}
}