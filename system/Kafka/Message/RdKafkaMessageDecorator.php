<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 03.05.2019
 * Time: 22:43
 */

namespace Kafka\Message;

use Helper\AbstractList;
use RdKafka\Message;
use ObjectMapper\ObjectMapper;

class RdKafkaMessageDecorator implements RdKafkaMessageDecoratorInterface
{
	/**
	 * @var Message
	 */
	private $message;

    /**
     * @var Payload
     */
	private $payloadEntity;

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
     * @param string $body
     * @return RdKafkaMessageDecorator
     */
	public function setBody(string $body): self
	{
		$this->entity = $body;

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
     * @return Payload
     * @throws \Exception\ObjectException
     */
	public function getPayloadEntity(): PayloadInterface
	{
	    if ($this->payloadEntity instanceof PayloadInterface) {
	        return $this->payloadEntity;
        }

        $this->payloadEntity = new Payload();
        $entity              = new $this->entity();

	    if ($entity instanceof AbstractList) {
            $this->payloadEntity->setObjectList($entity);
        } else if($entity instanceof AbstractQueueBody) {
            $this->payloadEntity->setBody($entity);
        } else {
	        throw new \InvalidArgumentException('No support this entity (' . $this->entity . ') for Payload');
        }

		ObjectMapper::create()->arrayToObject($this->getPayloadAsArray(), $this->payloadEntity);
	    return $this->payloadEntity;
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
		return $this->message->err !== RD_KAFKA_RESP_ERR_NO_ERROR;
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