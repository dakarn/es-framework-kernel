<?php

namespace Kafka\Message;

use Helper\AbstractList;
use ObjectMapper\ClassToMappingInterface;

interface RdKafkaMessageDecoratorInterface
{
    /**
     * @param string $bodyEntity
     * @return RdKafkaMessageDecorator
     */
    public function setBodyEntity(string $bodyEntity): \Kafka\RdKafkaMessageDecorator;

    /**
     * @param string $entityList
     * @return RdKafkaMessageDecorator
     */
    public function setEntityList(string $entityList): \Kafka\RdKafkaMessageDecorator;

    /**
     * @return string
     */
    public function getPayload(): string;

    /**
     * @return array
     */
    public function getPayloadAsArray(): array;

    /**
     * @return ClassToMappingInterface|Payload|AbstractList
     * @throws \Exception\ObjectException
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