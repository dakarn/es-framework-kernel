<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 02.05.2019
 * Time: 17:45
 */

namespace Kafka;

class KafkaProducer
{
	private $configureConnect;
	private $payload;

	public function __construct(ConfigureConnectInterface $configureConnect)
	{
		if (empty($configureConnect->getBrokers())) {
			throw new \RuntimeException('No brokers for connect');
		}

		$this->configureConnect = $configureConnect;
	}

	public function send()
	{
		$rk = new \RdKafka\Producer();
		$rk->setLogLevel(LOG_DEBUG);
		$rk->addBrokers(implode($this->configureConnect->getBrokers(), ','));

		$topic = $rk->newTopic($this->configureConnect->getTopic());

		$topic->produce(RD_KAFKA_PARTITION_UA, 0, json_encode($this->payload));
		$rk->poll(0);


	}

	public function setPayload(array $payload): self
	{
		$this->payload = $payload;

		return $this;
	}
}
