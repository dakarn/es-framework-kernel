<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 03.05.2019
 * Time: 0:59
 */

namespace System\Logger;

use Configs\Config;
use Kafka\ConfigConnection;
use Kafka\Groups;
use Kafka\Kafka;
use Kafka\Topics;

class LoggerKafkaQueue extends AbstractLoggerStorage implements LoggerStorageInterface
{
	/**
	 * @throws \Exception\FileException
	 */
	public function releaseLogs(): void
	{
		$configConnection = new ConfigConnection();
		$configConnection->setBrokers([Config::get('kafka', 'host')]);
		$configConnection->setTopic(Topics::LOGS);
		$configConnection->setGroup(Groups::MY_CONSUMER_GROUP);

		$kafka = Kafka::create()
			->setConfigConnection($configConnection)
			->getProducer();

		foreach ($this->logs as $log) {
			$time = microtime(true);
			$log = [
				'header' => [
					'topicName' => 'logs',
					'time'      => $time,
					'hash'      => md5($time . Topics::LOGS)
				],
				'body' => $log
			];

			$kafka->setPayload($log)->send();
		}

	}
}