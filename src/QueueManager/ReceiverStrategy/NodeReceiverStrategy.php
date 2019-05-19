<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 07.04.2018
 * Time: 0:55
 */

namespace ES\Kernel\QueueManager\ReceiverStrategy;

use ES\Kernel\QueueManager\QueueModelInterface;

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