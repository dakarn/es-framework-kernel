<?php

namespace ES\Kernel\Kafka\Message;

interface HeaderInterface
{
    public function getProperties(): array;

    /**
     * @return mixed
     */
    public function getAttempts();

    /**
     * @param mixed $attempts
     */
    public function setAttempts($attempts): void;

    /**
     * @return mixed
     */
    public function getHash();

    /**
     * @param mixed $hash
     */
    public function setHash($hash): void;

    /**
     * @return mixed
     */
    public function getTime();

    /**
     * @param mixed $time
     */
    public function setTime($time): void;

    /**
     * @return mixed
     */
    public function getTopicName();

    /**
     * @param mixed $topicName
     */
    public function setTopicName($topicName): void;
}