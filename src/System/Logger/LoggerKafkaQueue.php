<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 03.05.2019
 * Time: 0:59
 */

namespace ES\Kernel\System\Logger;

use ES\Kernel\Helper\Util;
use ES\Kernel\Kafka\Groups;
use ES\Kernel\Kafka\Topics;
use ES\Kernel\QueueManager\QueueManager;
use ES\Kernel\QueueManager\QueueModel;
use ES\Kernel\QueueManager\Senders\KafkaQueueSender;

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
				'hash'      => md5(microtime(true) . Topics::LOGS . Util::generateRandom(20)),
                'attempts'  => 1,
			],
		];

		foreach ($this->logs as $log) {
			$payload['bodyAsList'][] = $log;
		}

		if (empty($payload)) {
			return;
		}

		$send = new QueueModel();
		$send->setTopicName(Topics::LOGS)
			 ->setGroupId(Groups::MY_CONSUMER_GROUP)
			 ->setDataAsArray($payload);

		QueueManager::create()
			->setSender(KafkaQueueSender::class)
			->sender($send)
			->send();
	}
}