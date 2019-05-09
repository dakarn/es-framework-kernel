<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 03.05.2019
 * Time: 0:59
 */

namespace System\Logger;

use Helper\Util;
use Kafka\Groups;
use Kafka\Topics;
use QueueManager\QueueManager;
use QueueManager\QueueModel;
use QueueManager\Senders\KafkaQueueSender;

class LoggerKafkaQueue extends AbstractLoggerStorage implements LoggerStorageInterface
{
	/**
	 * @throws \Exception
	 */
	public function releaseLogs(): void
	{
		$payload = [
			'header' => [
				'topicName' => Topics::LOGS,
				'time'      => time(),
				'hash'      => md5(time() . Topics::LOGS . Util::generateRandom(20))
			],
		];

		foreach ($this->logs as $log) {
			$payload['bodyAsList'][] = $log;
		}

		$send = new QueueModel();
		$send->setTopicName(Topics::LOGS)
			 ->setGroupId(Groups::MY_CONSUMER_GROUP)
			 ->setDataAsArray($payload);

		QueueManager::create()
			->setSender(new KafkaQueueSender())
			->sender($send)
			->send();
	}
}