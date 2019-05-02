<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 03.05.2019
 * Time: 0:59
 */

namespace System\Logger;

use Kafka\ConfigureConnect;
use Kafka\Kafka;

class LoggerKafkaQueue extends AbstractLoggerStorage implements LoggerStorageInterface
{
	/**
	 *
	 */
	public function releaseLogs(): void
	{
		$connectConfig = new ConfigureConnect(['192.168.99.1'], 'test', 'myConsumerGroup');

		foreach ($this->logs as $log) {

			Kafka::create()
				->setConfigureConnect($connectConfig)
				->getProducer()
				->setBody($log)
				->send();
		}
	}
}