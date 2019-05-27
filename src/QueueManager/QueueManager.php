<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 01.04.2018
 * Time: 0:49
 */

namespace ES\Kernel\QueueManager;

use ES\Kernel\QueueManager\ReceiverStrategy\ReceiverStrategyInterface;
use ES\Kernel\Traits\SingletonTrait;
use ES\Kernel\QueueManager\Senders\QueueSenderInterface;
use ES\Kernel\QueueManager\ReceiverStrategy\RabbitReceiverStrategy;

class QueueManager implements QueueManagerInterface
{
	use SingletonTrait;

	/**
	 * @var RabbitReceiverStrategy
	 */
	private $receiver;

	/**
	 * @var array
	 */
	private $handlers = [];

	/**
	 * @var QueueSenderInterface
	 */
	private $sender;

    /**
     * @return ReceiverStrategyInterface
     */
	public function getReceiver(): ReceiverStrategyInterface
	{
		if (!$this->receiver instanceof ReceiverStrategyInterface) {
			throw new \RuntimeException('No install object with ReceiverStrategy');
		}

		return $this->receiver;
	}

	/**
	 * @param string $sender
	 * @return QueueManager
	 */
	public function setSender(string $sender): QueueManagerInterface
	{
		$this->sender = new $sender();
		return $this;
	}

	/**
	 * @param ReceiverStrategyInterface $receiverStrategy
	 * @return QueueManager
	 */
	public function setReceiver(ReceiverStrategyInterface $receiverStrategy): QueueManagerInterface
	{
		$this->receiver = $receiverStrategy;
		return $this;
	}

	/**
	 * @param string $name
	 * @param AbstractQueueHandler $queueHandler
	 * @return QueueManager
	 */
	public function setQueueHandler(string $name, AbstractQueueHandler $queueHandler): QueueManagerInterface
	{
		$this->handlers[$name] = $queueHandler;
		return $this;
	}

	/**
	 * @param array $queueHandlers
	 * @return QueueManager
	 */
	public function setQueueHandlers(array $queueHandlers): QueueManagerInterface
	{
		foreach ($queueHandlers as $name => $queueClass) {
			$this->handlers[$name] = $queueClass;
		}

		return $this;
	}

    /**
     * @return bool
     */
    public function runHandlers(): bool
    {
        \pcntl_async_signals(true);
        \pcntl_signal(SIGINT, [$this, 'handlerSignal']);
        \pcntl_signal(SIGTERM, [$this, 'handlerSignal']);

        foreach ($this->handlers as $name => $handler) {

            $pid = pcntl_fork();

            if ($pid > 0) {

                \cli_set_process_title($name . '-queue-fork-php');
                echo 'Create Fork: '. $name . PHP_EOL;

                /** @var AbstractQueueHandler $handler */
                $handler = $this->handlers[$name];
                $handler->prepareObject()->loopObserver();
            }
        }

        return true;
    }

	/**
	 * @param string $name
	 * @return bool
	 */
	public function runHandler(string $name): bool
	{
		if (empty($this->handlers[$name])) {
			throw new \LogicException('Handlers for queue was not setup or do not added!');
		}

		/** @var AbstractQueueHandler $handler */
		$handler = $this->handlers[$name];
		$handler->prepareObject()->loopObserver();
		return true;
	}

    /**
     * @param QueueModelInterface $queue
     * @return QueueSenderInterface
     */
	public function sender(QueueModelInterface $queue): QueueSenderInterface
	{
		if (!$this->sender instanceof QueueSenderInterface) {
            throw new \RuntimeException('No install object with QueueSenderInterface');
        }

		return $this->sender
			->setParams($queue)
			->build();
	}
}