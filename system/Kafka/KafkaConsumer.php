<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 02.05.2019
 * Time: 17:45
 */

namespace Kafka;

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
	 * @var AbstractKafkaHandler
	 */
	private $handlerClass;

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
	 * @param AbstractKafkaHandler $handlerClass
	 * @return KafkaConsumer
	 */
	public function setHandlerClass(AbstractKafkaHandler $handlerClass): KafkaConsumer
	{
		$this->handlerClass = $handlerClass;

		return $this;
	}

	/**
	 * @return KafkaConsumer
	 */
	public function waitMessage(): KafkaConsumer
	{
		while (true) {

			$message = $this->consumerTopic->consume(0, 120*10000);

			$messageDecorator = new RdKafkaMessageDecorator($message);

			if ($messageDecorator->getErr() === RD_KAFKA_RESP_ERR_NO_ERROR) {
				$this->handlerClass->setMessageDecorator($messageDecorator);
				$this->handlerClass->execute();
			}
		}

		return $this;
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