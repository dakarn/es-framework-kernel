<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 03.05.2019
 * Time: 22:43
 */

namespace Kafka;

use Kafka\Message\AbstractQueueBody;
use ObjectMapper\ClassToMappingInterface;
use RdKafka\Message;
use Kafka\Message\Payload;
use ObjectMapper\ObjectMapper;

class RdKafkaMessageDecorator
{
	/**
	 * @var Message
	 */
	private $message;

	/**
	 * @var AbstractQueueBody
	 */
	private $bodyEntity;

	/**
	 * RdKafkaMessage constructor.
	 * @param Message $message
	 */
	public function __construct(Message $message)
	{
		$this->message = $message;
	}

	/**
	 * @param string $bodyEntity
	 * @return RdKafkaMessageDecorator
	 */
	public function setBodyEntity(string $bodyEntity): self
	{
		$this->bodyEntity = $bodyEntity;

		return $this;
	}

	/**
	 * @return string
	 */
	public function getPayload(): string
	{
		return $this->message->payload;
	}

	/**
	 * @return array
	 */
	public function getPayloadAsArray(): array
	{
		return json_decode($this->message->payload, true);
	}

	/**
	 * @return ClassToMappingInterface|Payload
	 * @throws \Exception\ObjectException
	 */
	public function getPayloadEntity(): Payload
	{
		return ObjectMapper::create()->arrayToObject($this->getPayloadAsArray(), new Payload($this->bodyEntity));
	}

	/**
	 * @return int|null
	 */
	public function getLen():? int
	{
		return $this->message->len;
	}

	/**
	 * @return int
	 */
	public function getOffset(): int
	{
		return $this->message->offset;
	}

	/**
	 * @return int
	 */
	public function getPartition(): int
	{
		return $this->message->partition;
	}

	/**
	 * @return int
	 */
	public function getErr(): int
	{
		return $this->message->err;
	}

	/**
	 * @return string
	 */
	public function getTopicName(): string
	{
		return $this->message->topic_name;
	}

	/**
	 * @return null|string
	 */
	public function getKey():? string
	{
		return $this->message->key;
	}

	/**
	 * @return string
	 */
	public function getErrorString(): string
	{
		return $this->message->errstr();
	}

	/**
	 * @return bool
	 */
	public function isEmptyPayload(): bool
	{
		return empty($this->message->payload);
	}
}