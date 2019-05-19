<?php

namespace ES\Kernel\Kafka\Message;

interface HeaderInterface
{
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