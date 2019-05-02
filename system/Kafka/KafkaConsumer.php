<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 02.05.2019
 * Time: 17:45
 */

namespace Kafka;

class KafkaConsumer
{
	private $configureConnect;

	public function __construct(ConfigureConnectInterface $configureConnect)
	{
		if (empty($configureConnect->getBrokers())) {
			throw new \RuntimeException('No brokers for connect');
		}

		$this->configureConnect = $configureConnect;
	}
}