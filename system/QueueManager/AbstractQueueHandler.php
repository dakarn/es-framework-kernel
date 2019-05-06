<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 02.04.2018
 * Time: 1:03
 */

namespace QueueManager;

use QueueManager\Strategy\ReceiverStrategyInterface;

abstract class AbstractQueueHandler
{
	/**
	 * @var ReceiverStrategyInterface
	 */
	protected $strategy;

	/**
	 * @var QueueModelInterface
	 */
	protected $queueParam;

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
	abstract public function before();

	/**
	 * @return bool
	 */
	abstract public function executeTask(): bool;

	/**
	 * @return mixed
	 */
	abstract public function after();
}