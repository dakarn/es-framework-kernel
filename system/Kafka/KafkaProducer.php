<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 02.05.2019
 * Time: 17:45
 */

namespace Kafka;

use RdKafka\Producer;

class KafkaProducer
{
	private $configureConnect;

	/**
	 * @var Producer
	 */
	private $producer;

	/**
	 * KafkaProducer constructor.
	 * @param ConfigureConnectInterface $configureConnect
	 */
	public function __construct(ConfigureConnectInterface $configureConnect)
	{
		if (empty($configureConnect->getBrokers())) {
			throw new \RuntimeException('No brokers for connect');
		}

		$this->configureConnect = $configureConnect;
		$this->prepareObject();
	}

	public function prepareObject()
	{
		$this->producer = new Producer();
		$this->producer->setLogLevel(LOG_DEBUG);
		$this->producer->addBrokers(implode($this->configureConnect->getBrokers(), ','));
	}

	/**
	 * @return Producer
	 */
	public function getProducer(): Producer
	{
		return $this->producer;
	}
}
