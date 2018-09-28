<?php
/**
 * Created by PhpStorm.
 * User: v.konovalov
 * Date: 24.04.2018
 * Time: 14:45
 */

namespace QueueManager;

use QueueManager\Senders\QueueSenderInterface;
use QueueManager\Strategy\ReceiverStrategyInterface;

interface QueueManagerInterface
{
    /**
     * @return ReceiverStrategyInterface
     */
    public function getReceiver(): ReceiverStrategyInterface;

    /**
     * @param string $name
     * @param AbstractQueueHandler $queueHandler
     * @return QueueManager
     */
    public function setQueueHandler(string $name, AbstractQueueHandler $queueHandler): QueueManager;

    /**
     * @param array $queueHandlers
     * @return QueueManager
     */
    public function setQueueHandlers(array $queueHandlers): QueueManager;

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
     * @param QueueModel $queue
     * @return QueueSenderInterface
     */
    public function sender(QueueModel $queue): QueueSenderInterface;
}