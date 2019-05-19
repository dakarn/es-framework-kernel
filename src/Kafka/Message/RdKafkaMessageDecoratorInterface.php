<?php

namespace ES\Kernel\Kafka\Message;

use ES\Kernel\Helper\AbstractList;
use ES\Kernel\ObjectMapper\ClassToMappingInterface;

interface RdKafkaMessageDecoratorInterface
{
    /**
     * @param string $bodyEntity
     * @return RdKafkaMessageDecorator
     */
    public function setBody(string $bodyEntity): RdKafkaMessageDecorator;

    /**
     * @return string
     */
    public function getPayloadSource():? string;

    /**
     * @return array
     */
    public function getPayloadAsArray():? array;

	/**
	 * @return Payload
	 */
    public function getPayloadEntity(): Payload;

    /**
     * @return int|null
     */
    public function getLen(): ?int;

    /**
     * @return int
     */
    public function getOffset(): int;

    /**
     * @return int
     */
    public function getPartition(): int;

    /**
     * @return int
     */
    public function getErr(): int;

    /**
     * @return bool
     */
    public function hasError(): bool;

    /**
     * @return string
     */
    public function getTopicName(): string;

    /**
     * @return null|string
     */
    public function getKey(): ?string;

    /**
     * @return string
     */
    public function getErrorString(): string;

    /**
     * @return bool
     */
    public function isEmptyPayload(): bool;
}