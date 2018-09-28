<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 07.04.2018
 * Time: 0:55
 */

namespace QueueManager\Strategy;

use QueueManager\QueueModel;

class NodeReceiverStrategy implements ReceiverStrategyInterface
{
	public function setParams(QueueModel $params): ReceiverStrategyInterface
	{
		return $this;
	}

	public function build()
	{

	}
}