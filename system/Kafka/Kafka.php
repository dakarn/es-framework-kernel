<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 02.05.2019
 * Time: 19:32
 */

namespace Kafka;

use Traits\SingletonTrait;

class Kafka
{
	use SingletonTrait;

	private $consumer;
	private $producer;

	private $configureConnect;

	public function setConfigureConnect(ConfigureConnectInterface $configureConnect): Kafka
	{
		$this->configureConnect = $configureConnect;

		return $this;
	}

	public function getProducer(): KafkaProducer
	{
		if (!$this->producer instanceof KafkaProducer) {
			$this->producer = new KafkaProducer($this->configureConnect);
		}

		return $this->producer;
	}

	public function getConsumer(): KafkaConsumer
	{
		if (!$this->producer instanceof KafkaConsumer) {
			$this->producer = new KafkaConsumer($this->configureConnect);
		}

		return $this->consumer;
	}
}