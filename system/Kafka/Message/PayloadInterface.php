<?php

namespace Kafka\Message;

use Helper\AbstractList;

interface PayloadInterface
{
    public function setBody(AbstractQueueBody $queueBody): Payload;

    /**
     * @return mixed
     */
    public function getHeader(): Header;

    /**
     * @return mixed
     */
    public function getBody(): ?AbstractQueueBody;

    /**
     * @return AbstractList|null
     */
    public function getObjectList(): ?AbstractList;

    /**
     * @param AbstractList $objectList
     * @return AbstractList
     */
    public function setObjectList(AbstractList $objectList): AbstractList;
}