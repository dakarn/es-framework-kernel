<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 04.05.2019
 * Time: 14:49
 */

namespace Kafka;

abstract class AbstractKafkaHandler
{
	/**
	 * @var RdKafkaMessageDecorator
	 */
	private $messageDecorator;

	/**
	 * @param RdKafkaMessageDecorator $messageDecorator
	 */
	public function setMessageDecorator(RdKafkaMessageDecorator $messageDecorator): void
	{
		$this->messageDecorator = $messageDecorator;
	}

	/**
	 * @return RdKafkaMessageDecorator
	 */
	public function getMessageDecorator(): RdKafkaMessageDecorator
	{
		return $this->messageDecorator;
	}

	abstract public function execute();
}