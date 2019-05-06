<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 04.05.2019
 * Time: 19:34
 */

namespace QueueManager\ReceiverStrategy;

use QueueManager\QueueModelInterface;
use Kafka\ConfigConnection;
use Configs\Config;
use Kafka\Kafka;

class KafkaReceiverStrategy implements ReceiverStrategyInterface
{
	private $params;
	private $configConnection;
	private $queueInstance;

	public function __construct()
	{
	}

	public function setParams(QueueModelInterface $params): ReceiverStrategyInterface
	{
		$this->params = $params;
		
		return $this;
	}

	/**
	 * @return mixed|void
	 * @throws \Exception\FileException
	 */
	public function build()
	{
		$this->configConnection = new ConfigConnection();
		$this->configConnection->setBrokers([Config::get('kafka', 'host')]);
		$this->configConnection->setTopic($this->params->getTopicName());
		$this->configConnection->setGroup($this->params->getGroupId());

		$this->queueInstance = Kafka::create()
			->setConfigConnection($this->configConnection)
			->getConsumer()
			->getConsumerTopic();
	}
	
	public function getCreatedObject(): array
	{
		return ['consumerTopic' => $this->queueInstance];
	}

}