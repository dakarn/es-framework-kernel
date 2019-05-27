<?php

namespace ES\Kernel\QueueManager;

use ES\Kernel\QueueManager\ReceiverStrategy\ReceiverStrategyInterface;
use ES\Kernel\QueueManager\Senders\QueueSenderInterface;

interface QueueManagerInterface
{
    /**
     * @return ReceiverStrategyInterface
     */
    public function getReceiver(): ReceiverStrategyInterface;

    /**
     * @param string $sender
     * @return QueueManager
     */
    public function setSender(string $sender): QueueManagerInterface;

    /**
     * @param ReceiverStrategyInterface $receiverStrategy
     * @return QueueManager
     */
    public function setReceiver(ReceiverStrategyInterface $receiverStrategy): QueueManagerInterface;

    /**
     * @param string $name
     * @param AbstractQueueHandler $queueHandler
     * @return QueueManager
     */
    public function setQueueHandler(string $name, AbstractQueueHandler $queueHandler): QueueManagerInterface;

    /**
     * @param array $queueHandlers
     * @return QueueManager
     */
    public function setQueueHandlers(array $queueHandlers): QueueManagerInterface;

    /**
     * @return bool
     */
    public function runHandlers(): bool;

    /**
     * @param string $name
     * @return bool
     */
    public function runHandler(string $name): bool;

    /**
     * @param QueueModelInterface $queue
     * @return QueueSenderInterface
     */
    public function sender(QueueModelInterface $queue): QueueSenderInterface;
}