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
	 * @var QueueModel
	 */
	protected $queueParam;

	/**
	 * @return AbstractQueueHandler
	 */
	public function prepareObject(): self
	{
		$this->prepare();
		$this->before();

		return $this;
	}

	/**
	 * @return void
	 */
	public function loopObserver()
	{
		$this->run();
	}

	/**
	 * @return mixed
	 */
	abstract public function before();

	/**
	 * @return mixed
	 */
	abstract public function prepare();

	/**
	 * @return bool
	 */
	abstract public function run(): bool;

	/**
	 * @return mixed
	 */
	abstract public function after();
}