<?php

namespace ES\Kernel\QueueManager;

interface QueueModelInterface
{
    /**
     * @return string
     */
    public function getGroupId(): string;

    /**
     * @param string $groupId
     * @return \QueueManager\QueueModelInterface
     */
    public function setGroupId(string $groupId): QueueModelInterface;

    /**
     * @param string $type
     * @return \QueueManager\QueueModelInterface
     */
    public function setType(string $type): QueueModelInterface;

    /**
     * @param string $data
     * @return \QueueManager\QueueModelInterface
     */
    public function setData(string $data): QueueModelInterface;

    /**
     * @param array $data
     * @return \QueueManager\QueueModelInterface
     */
    public function setDataAsArray(array $data): QueueModelInterface;

    /**
     * @param string $exchangeName
     * @return \QueueManager\QueueModelInterface
     */
    public function setExchangeName(string $exchangeName): QueueModelInterface;

    /**
     * @param string $flags
     * @return \QueueManager\QueueModelInterface
     */
    public function setFlags(string $flags): QueueModelInterface;

    /**
     * @param string $name
     * @return \QueueManager\QueueModelInterface
     */
    public function setTopicName(string $name): QueueModelInterface;

    /**
     * @param string $routingKey
     * @return \QueueManager\QueueModelInterface
     */
    public function setRoutingKey(string $routingKey): QueueModelInterface;

    /**
     * @return string
     */
    public function getType(): string;

    /**
     * @return string
     */
    public function getData(): string;

    /**
     * @return string
     */
    public function getExchangeName(): string;

    /**
     * @return string
     */
    public function getFlags(): string;

    /**
     * @return string
     */
    public function getRoutingKey(): string;

    /**
     * @return string
     */
    public function getTopicName(): string;
}