<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 03.05.2019
 * Time: 22:43
 */

namespace ES\Kernel\Kafka\Message;

use ES\Kernel\Helper\AbstractList;
use RdKafka\Message;
use ES\Kernel\ObjectMapper\ObjectMapper;

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
     * @param string $body
     * @return RdKafkaMessageDecorator
     */
	public function setBody(string $body): self
	{
		$this->bodyEntity = $body;

		return $this;
	}

	/**
	 * @param string $bodyList
	 * @return RdKafkaMessageDecorator
	 */
	public function setBodyAsList(string $bodyList): self
	{
		$this->bodyEntity = $bodyList;

		return $this;
	}

	/**
	 * @return string
	 */
	public function getPayloadSource():? string
	{
		return $this->message->payload;
	}

	/**
	 * @return array
	 */
	public function getPayloadAsArray():? array
	{
		return json_decode($this->message->payload, true);
	}

    /**
     * @return Payload
     * @throws \ES\Kernel\Exception\ObjectException
     */
	public function getPayloadEntity(): Payload
	{
	    if ($this->payloadEntity instanceof Payload) {
	        return $this->payloadEntity;
        }

		$entity              = new $this->bodyEntity();
        $this->payloadEntity = new Payload();

	    if ($entity instanceof AbstractList) {
            $this->payloadEntity->setBodyAsList($entity);
        } else if($entity instanceof AbstractQueueBody) {
            $this->payloadEntity->setBody($entity);
        } else {
	        throw new \InvalidArgumentException('No support this entity (' . $this->bodyEntity . ') for Payload');
        }

		return ObjectMapper::create()->arrayToObject($this->getPayloadAsArray(), $this->payloadEntity);
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