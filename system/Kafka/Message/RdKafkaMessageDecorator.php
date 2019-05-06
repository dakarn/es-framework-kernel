<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 03.05.2019
 * Time: 22:43
 */

namespace Kafka\Message;

use Helper\AbstractList;
use ObjectMapper\ClassToMappingInterface;
use RdKafka\Message;
use ObjectMapper\ObjectMapper;

class RdKafkaMessageDecorator implements RdKafkaMessageDecoratorInterface
{
	/**
	 * @var Message
	 */
	private $message;

	/**
	 * @var AbstractQueueBody|AbstractList
	 */
	private $entity;

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
		$this->entity = $bodyEntity;

		return $this;
	}

    /**
     * @param string $entityList
     * @return RdKafkaMessageDecorator
     */
	public function setEntityList(string $entityList): self
	{
		$this->entity = $entityList;

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
	 * @return ClassToMappingInterface|Payload|AbstractList
	 * @throws \Exception\ObjectException
	 */
	public function getPayloadEntity(): Payload
	{
        $payloadObject = new Payload();
        $entity        = new $this->entity();

	    if ($entity instanceof AbstractList) {
            $payloadObject->setObjectList($entity);
        } else if($entity instanceof AbstractQueueBody) {
            $payloadObject->setBody($entity);
        } else {
	        throw new \InvalidArgumentException('No support this entity (' . $this->entity . ') for Kafka Payload');
        }

		return ObjectMapper::create()->arrayToObject($this->getPayloadAsArray(), $payloadObject);
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
	 * @return bool
	 */
	public function hasError(): bool
	{
		return $this->message->err === RD_KAFKA_RESP_ERR_NO_ERROR;
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