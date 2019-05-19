<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 02.05.2019
 * Time: 17:45
 */

namespace ES\Kernel\Kafka;

use RdKafka\Conf;
use RdKafka\Consumer;
use RdKafka\ConsumerTopic;
use RdKafka\TopicConf;

class KafkaConsumer
{
	/**
	 * @var ConfigureConnectInterface
	 */
	private $configConnection;

	/**
	 * @var Conf
	 */
	private $kafkaConf;

	/**
	 * @var \RdKafka\KafkaConsumer
	 */
	private $rdKafkaConsumer;

	/**
	 * @var ConsumerTopic
	 */
	private $consumerTopic;

	/**
	 * KafkaConsumer constructor.
	 * @param ConfigureConnectInterface $configConnection
	 */
	public function __construct(ConfigureConnectInterface $configConnection)
	{
		if (empty($configConnection->getBrokers())) {
			throw new \RuntimeException('No brokers for connect');
		}

		$this->configConnection = $configConnection;
		$this->prepareObject();
	}

	/**
	 * @return ConsumerTopic
	 */
	public function getConsumerTopic(): ConsumerTopic
	{
		return $this->consumerTopic;
	}

	/**
	 * @return KafkaConsumer
	 */
	public function prepareObject(): KafkaConsumer
	{
		$this->kafkaConf = new Conf();

		$this->kafkaConf->set('group.id', $this->configConnection->getGroup());

		$this->rdKafkaConsumer = new Consumer($this->kafkaConf);
		$this->rdKafkaConsumer->addBrokers(implode($this->configConnection->getBrokers(), ','));

		$topicConf = new TopicConf();
		$topicConf->set('auto.commit.interval.ms', 100);

		$this->consumerTopic = $this->rdKafkaConsumer->newTopic($this->configConnection->getTopic(), $topicConf);
		$this->consumerTopic->consumeStart(0, RD_KAFKA_OFFSET_STORED);

		return $this;
	}
}