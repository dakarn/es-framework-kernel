<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 02.04.2018
 * Time: 1:03
 */

namespace ES\Kernel\QueueManager;

use ES\Kernel\QueueManager\ReceiverStrategy\KafkaReceiverStrategy;

abstract class AbstractQueueHandler
{
	/**
	 * @var KafkaReceiverStrategy
	 */
	protected $strategy;

	/**
	 * @var QueueModelInterface
	 */
	protected $queueParam;

	/**
	 * @return bool
	 */
	public function loopObserver(): bool
	{
		while (true) {
			$message = $this->getMessage();
			$this->executeTask($message);
		}

		return true;
	}

	/**
	 * @return AbstractQueueHandler
	 */
	public function prepareObject(): self
	{
		$this->before();

		return $this;
	}

	/**
	 * @return mixed
	 */
	abstract protected function before();

	/**
	 * @return bool
	 */
	abstract protected function executeTask($message): bool;

	/**
	 * @return mixed
	 */
	abstract protected function after();

	/**
	 * @return mixed
	 */
	abstract public function getMessage();
}