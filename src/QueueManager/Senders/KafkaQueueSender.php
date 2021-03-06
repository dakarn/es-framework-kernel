<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 04.05.2019
 * Time: 1:11
 */

namespace ES\Kernel\QueueManager\Senders;

use ES\Kernel\QueueManager\QueueModelInterface;
use RdKafka\Producer;
use RdKafka\ProducerTopic;
use ES\Kernel\Configs\Config;
use ES\Kernel\Kafka\ConfigConnection;
use ES\Kernel\Kafka\Kafka;

class KafkaQueueSender implements QueueSenderInterface
{
	/**
	 * @var ProducerTopic
	 */
	private $producerTopic;

	/**
	 * @var Producer
	 */
	private $producer;

	/**
	 * @var QueueModelInterface
	 */
	private $params;

	/**
	 * @return QueueSenderInterface
	 * @throws \ES\Kernel\Exception\FileException
	 */
	public function build(): QueueSenderInterface
	{
		$configConnection = new ConfigConnection();
		$configConnection->setBrokers([Config::get('kafka', 'host')]);
		$configConnection->setTopic($this->params->getTopicName());
		$configConnection->setGroup($this->params->getGroupId());

		$producer = Kafka::create()
			->setConfigConnection($configConnection)
			->getProducer();

		$this->producer      = $producer->getProducer();
		$this->producerTopic = $this->producer->newTopic($this->params->getTopicName());

		return $this;
	}

	/**
	 * @param bool $isClose
	 * @return mixed|void
	 */
	public function send(bool $isClose = false)
	{
		$this->producerTopic->produce(RD_KAFKA_PARTITION_UA, 0, $this->params->getData());
		$this->producer->poll(0);
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
		$this->params->setDataAsArray($data);

		return $this;
	}
}