<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 03.05.2019
 * Time: 0:59
 */

namespace System\Logger;

use Configs\Config;
use Kafka\ConfigureConnect;
use Kafka\Kafka;

class LoggerKafkaQueue extends AbstractLoggerStorage implements LoggerStorageInterface
{
	/**
	 * @throws \Exception\FileException
	 */
	public function releaseLogs(): void
	{
		$connectConfig = new ConfigureConnect([Config::get('kafka', 'host')], 'logs', 'myConsumerGroup');
		$kafka = Kafka::create()
			->setConfigureConnect($connectConfig)
			->getProducer();

		foreach ($this->logs as $log) {
			$microtime = microtime(true);
			$log = [
				'header' => [
					'topicName' => 'logs',
					'time'      => $microtime,
					'hash'      => md5($microtime . 'logs')
				],
				'body' => $log
			];

			$kafka->setPayload($log)->send();
		}

	}
}