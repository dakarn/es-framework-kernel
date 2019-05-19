<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 07.04.2018
 * Time: 0:56
 */

namespace ES\Kernel\QueueManager\Senders;

use ES\Kernel\QueueManager\QueueModelInterface;

/**
 * Class NodeQueueSender
 * @package QueueManager\Senders
 */
class NodeQueueSender implements QueueSenderInterface
{
	/**
	 * @param QueueModelInterface $params
	 * @return QueueSenderInterface
	 */
	public function setParams(QueueModelInterface $params): QueueSenderInterface
	{
		return $this;
	}

	/**
	 * @param string $data
	 * @return QueueSenderInterface
	 */
	public function setDataString(string $data): QueueSenderInterface
	{
		return $this;
	}

    /**
     * @param array $data
     * @return QueueSenderInterface
     */
	public function setDataArray(array $data): QueueSenderInterface
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