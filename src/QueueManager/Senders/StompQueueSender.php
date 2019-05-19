<?php
/**
 * Created by PhpStorm.
 * User: v.konovalov
 * Date: 28.05.2018
 * Time: 10:39
 */
namespace ES\Kernel\QueueManager\Senders;

use ES\Kernel\Configs\Config;
use ES\Kernel\QueueManager\QueueModelInterface;

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
     * @var QueueModelInterface
     */
    private $params;

	/**
	 * StompQueueSender constructor.
	 * @throws \ES\Kernel\Exception\FileException
	 */
    public function __construct()
    {
        $this->configConnect = Config::get('stomp');
    }

    /**
     * @param QueueModelInterface $params
     * @return QueueSenderInterface
     */
    public function setParams(QueueModelInterface $params): QueueSenderInterface
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
    public function setDataString(string $data): QueueSenderInterface
    {
        $this->params->setData($data);
        return $this;
    }

    public function setDataArray(array $data): QueueSenderInterface
    {
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