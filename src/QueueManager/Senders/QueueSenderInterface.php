<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 04.04.2018
 * Time: 14:28
 */

namespace ES\Kernel\QueueManager\Senders;

use ES\Kernel\QueueManager\QueueModelInterface;

interface QueueSenderInterface
{
	/**
	 * @param QueueModelInterface $params
	 * @return QueueSenderInterface
	 */
	public function setParams(QueueModelInterface $params): QueueSenderInterface;

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
    public function setDataString(string $data): QueueSenderInterface;

	/**
	 * @param array $data
	 * @return QueueSenderInterface
	 */
    public function setDataArray(array $data): QueueSenderInterface;
}