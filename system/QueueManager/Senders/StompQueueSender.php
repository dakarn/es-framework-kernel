<?php
/**
 * Created by PhpStorm.
 * User: v.konovalov
 * Date: 28.05.2018
 * Time: 10:39
 */
namespace QueueManager\Senders;

use Configs\Config;
use QueueManager\QueueModel;

class StompQueueSender implements QueueSenderInterface
{
    /**
     * @var \Stomp
     */
    private $stomp;

    /**
     * @var array
     */
    private $configConnect = [];

    /**
     * @var QueueModel
     */
    private $params;

    /**
     * RabbitQueueSender constructor.
     */
    public function __construct()
    {
        $this->configConnect = Config::get('stomp');
    }

    /**
     * @param QueueModel $params
     * @return QueueSenderInterface
     */
    public function setParams(QueueModel $params): QueueSenderInterface
    {
        $this->params = $params;
        return $this;
    }

    /**
     * @return QueueSenderInterface
     */
    public function build(): QueueSenderInterface
    {
        if ($this->stomp instanceof \Stomp) {
            return $this;
        }

        $this->stomp = new \Stomp($this->configConnect['host'], $this->configConnect['login'], $this->configConnect['password']);
        return $this;
    }

    /**
     * @param string $data
     * @return QueueSenderInterface
     */
    public function setDataForSend(string $data): QueueSenderInterface
    {
        $this->params->setData($data);
        return $this;
    }

    /**
     * @param bool $isClose
     * @return bool
     */
    public function send(bool $isClose = false)
    {
        $result = $this->stomp->send($this->params->getData(), $this->params->getRoutingKey());

        if ($isClose) {
            $this->disconnect();
        }

        return $result;
    }

    /**
     * @return void
     */
    public function disconnect(): void
    {
        unset($this->stomp);
    }
}