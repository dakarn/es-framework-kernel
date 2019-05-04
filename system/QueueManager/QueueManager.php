<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 01.04.2018
 * Time: 0:49
 */

namespace QueueManager;

use QueueManager\Senders\RabbitQueueSender;
use QueueManager\Strategy\ReceiverStrategyInterface;
use Traits\SingletonTrait;
use QueueManager\Senders\QueueSenderInterface;
use QueueManager\Strategy\RabbitReceiverStrategy;

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
	 * @throws \Exception\FileException
	 */
	public function getReceiver(): ReceiverStrategyInterface
	{
		if (!$this->receiver instanceof ReceiverStrategyInterface) {
			$this->receiver = new RabbitReceiverStrategy();
		}

		return $this->receiver;
	}

	/**
	 * @param QueueSenderInterface $sender
	 * @return QueueManager
	 */
	public function setSender(QueueSenderInterface $sender): QueueManager
	{
		$this->sender = new $sender();
		return $this;
	}

	/**
	 * @param ReceiverStrategyInterface $receiverStrategy
	 * @return QueueManager
	 */
	public function setReceiver(ReceiverStrategyInterface $receiverStrategy): QueueManager
	{
		$this->receiver = $receiverStrategy;
		return $this;
	}

	/**
	 * @param string $name
	 * @param AbstractQueueHandler $queueHandler
	 * @return QueueManager
	 */
	public function setQueueHandler(string $name, AbstractQueueHandler $queueHandler): QueueManager
	{
		$this->handlers[$name] = $queueHandler;
		return $this;
	}

	/**
	 * @param array $queueHandlers
	 * @return QueueManager
	 */
	public function setQueueHandlers(array $queueHandlers): QueueManager
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

                $this->handlers[$name]->prepareObject()->loopObserver();
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

		$this->handlers[$name]->prepareObject()->loopObserver();
		return true;
	}

	/**
	 * @param QueueModel $queue
	 * @return QueueSenderInterface
	 * @throws \Exception\FileException
	 */
	public function sender(QueueModel $queue): QueueSenderInterface
	{
		if (!$this->sender instanceof QueueSenderInterface) {
			$this->sender = new RabbitQueueSender();
		}

		return $this->sender
			->setParams($queue)
			->build();
	}
}