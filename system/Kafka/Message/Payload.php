<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 04.05.2019
 * Time: 0:08
 */

namespace Kafka\Message;

use Helper\AbstractList;
use ObjectMapper\ClassToMappingInterface;

class Payload implements ClassToMappingInterface, PayloadInterface
{
	private $header;
	private $body;
	private $objectList;

    /**
     * Payload constructor.
     */
	public function __construct()
	{
		$this->header = new Header();
	}

	public function setBody(AbstractQueueBody $queueBody): Payload
    {
        $this->body = $queueBody;

        return $this;
    }

	/**
	 * @return mixed
	 */
	public function getHeader(): Header
	{
		return $this->header;
	}

	/**
	 * @return mixed
	 */
	public function getBody():? AbstractQueueBody
	{
		return $this->body;
	}

    /**
     * @return AbstractList|null
     */
	public function getObjectList():? AbstractList
    {
        return $this->objectList;
    }

    /**
     * @param AbstractList $objectList
     * @return AbstractList
     */
    public function setObjectList(AbstractList $objectList): AbstractList
    {
        return $this->objectList = $objectList;
    }

}