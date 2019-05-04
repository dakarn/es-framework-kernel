<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 04.04.2018
 * Time: 14:28
 */

namespace QueueManager\Senders;

use QueueManager\QueueModel;

interface QueueSenderInterface
{
	/**
	 * @param QueueModel $params
	 * @return QueueSenderInterface
	 */
	public function setParams(QueueModel $params): QueueSenderInterface;

	/**
	 * @return QueueSenderInterface
	 */
	public function build(): QueueSenderInterface;

	/**
	 * @param bool $isClose
	 * @return mixed
	 */
    public function send(bool $isClose = false);

	/**
	 * @param string $data
	 * @return QueueSenderInterface
	 */
    public function setData(string $data): QueueSenderInterface;

	/**
	 * @param array $data
	 * @return QueueSenderInterface
	 */
    public function setDataArray(array $data): QueueSenderInterface;
}