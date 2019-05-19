<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 02.05.2019
 * Time: 19:32
 */

namespace ES\Kernel\Kafka;

use ES\Kernel\Traits\SingletonTrait;

class Kafka implements KafkaInterface
{
	use SingletonTrait;

	private $consumer;
	private $producer;
	private $configureConnect;

    /**
     * @param ConfigureConnectInterface $configureConnect
     * @return Kafka
     */
	public function setConfigConnection(ConfigureConnectInterface $configureConnect): Kafka
	{
		$this->configureConnect = $configureConnect;

		return $this;
	}

    /**
     * @return KafkaProducer
     */
	public function getProducer(): KafkaProducer
	{
		if (!$this->producer instanceof KafkaProducer) {
			$this->producer = new KafkaProducer($this->configureConnect);
		}

		return $this->producer;
	}

    /**
     * @return KafkaConsumer
     */
	public function getConsumer(): KafkaConsumer
	{
		if (!$this->consumer instanceof KafkaConsumer) {
			$this->consumer = new KafkaConsumer($this->configureConnect);
		}

		return $this->consumer;
	}
}