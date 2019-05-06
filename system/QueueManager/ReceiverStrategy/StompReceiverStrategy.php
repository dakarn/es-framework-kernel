<?php
/**
 * Created by PhpStorm.
 * User: v.konovalov
 * Date: 28.05.2018
 * Time: 10:47
 */

namespace QueueManager\ReceiverStrategy;

use AMQPConnection;
use Configs\Config;
use QueueManager\QueueModelInterface;

class StompReceiverStrategy implements ReceiverStrategyInterface
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
	 * StompReceiverStrategy constructor.
	 * @throws \Exception\FileException
	 */
    public function __construct()
    {
        $this->configConnect = Config::get('stomp');
    }

    /**
     * @param QueueModelInterface $params
     * @return ReceiverStrategyInterface
     */
    public function setParams(QueueModelInterface $params): ReceiverStrategyInterface
    {
        $this->params = $params;
        return $this;
    }

	/**
	 * @return $this|mixed
	 */
    public function build()
    {
        if (!$this->params instanceof QueueModelInterface) {
            throw new \LogicException('Object data for connection with QueueServer do not filled!');
        }

        $this->connection();
        $this->stomp->subscribe($this->params->getName());

        return $this;
    }

    /**
     * @return array
     */
    public function getCreatedObject(): array
    {
        return ['stomp' => $this->stomp];
    }

	/**
	 * @return StompReceiverStrategy
	 */
    private function connection(): self
    {
        $this->stomp = new \Stomp($this->configConnect['host'], $this->configConnect['login'], $this->configConnect['password']);

        return $this;
    }
}
