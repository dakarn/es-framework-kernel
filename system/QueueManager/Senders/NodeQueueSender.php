<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 07.04.2018
 * Time: 0:56
 */

namespace QueueManager\Senders;

use QueueManager\QueueModel;

/**
 * Class NodeQueueSender
 * @package QueueManager\Senders
 */
class NodeQueueSender implements QueueSenderInterface
{
	/**
	 * @param QueueModel $params
	 * @return QueueSenderInterface
	 */
	public function setParams(QueueModel $params): QueueSenderInterface
	{
		return $this;
	}

	/**
	 * @param string $data
	 * @return QueueSenderInterface
	 */
	public function setData(string $data): QueueSenderInterface
	{
		return $this;
	}

	/**
	 * @return QueueSenderInterface
	 */
	public function build(): QueueSenderInterface
	{
		return $this;
	}

	/**
	 * @param bool $isClose
	 * @return bool|mixed
	 */
	public function send(bool $isClose = false)
    {
		return true;
    }
}