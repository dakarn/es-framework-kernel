<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 04.05.2019
 * Time: 1:11
 */

namespace QueueManager\Senders;

use QueueManager\QueueModel;
use RdKafka\Producer;
use RdKafka\ProducerTopic;
use Configs\Config;
use Kafka\ConfigConnection;
use Kafka\Topics;
use Kafka\Groups;
use Kafka\Kafka;

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
	 * @var QueueModel
	 */
	private $params;

	/**
	 * @return QueueSenderInterface
	 * @throws \Exception\FileException
	 */
	public function build(): QueueSenderInterface
	{
		$configConnection = new ConfigConnection();
		$configConnection->setBrokers([Config::get('kafka', 'host')]);
		$configConnection->setTopic(Topics::LOGS);
		$configConnection->setGroup(Groups::MY_CONSUMER_GROUP);

		$producer = Kafka::create()
			->setConfigConnection($configConnection)
			->getProducer();

		$this->producer      = $producer->getProducer();
		$this->producerTopic = $this->producer->newTopic($configConnection->getTopic());

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
	 * @param QueueModel $params
	 * @return QueueSenderInterface
	 */
	public function setParams(QueueModel $params): QueueSenderInterface
	{
		$this->params = $params;

		return $this;
	}

	/**
	 * @param string $data
	 * @return QueueSenderInterface
	 */
	public function setData(string $data): QueueSenderInterface
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