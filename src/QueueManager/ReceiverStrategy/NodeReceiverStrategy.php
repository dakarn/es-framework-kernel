<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 07.04.2018
 * Time: 0:55
 */

namespace QueueManager\ReceiverStrategy;

use QueueManager\QueueModelInterface;

class NodeReceiverStrategy implements ReceiverStrategyInterface
{
	public function setParams(QueueModelInterface $params): ReceiverStrategyInterface
	{
		return $this;
	}

	public function build()
	{

	}
}