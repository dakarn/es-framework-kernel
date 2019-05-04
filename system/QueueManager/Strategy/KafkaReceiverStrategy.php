<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 04.05.2019
 * Time: 19:34
 */

namespace QueueManager\Strategy;

use QueueManager\QueueModel;

class KafkaReceiverStrategy implements ReceiverStrategyInterface
{
	public function setParams(QueueModel $params): ReceiverStrategyInterface
	{
		return $this;
	}

	public function build()
	{

	}
}