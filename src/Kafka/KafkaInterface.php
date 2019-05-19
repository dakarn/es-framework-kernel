<?php

namespace ES\Kernel\Kafka;

interface KafkaInterface
{
    /**
     * @param ConfigureConnectInterface $configureConnect
     * @return Kafka
     */
    public function setConfigConnection(ConfigureConnectInterface $configureConnect): Kafka;

    /**
     * @return KafkaProducer
     */
    public function getProducer(): KafkaProducer;

    /**
     * @return KafkaConsumer
     */
    public function getConsumer(): KafkaConsumer;
}