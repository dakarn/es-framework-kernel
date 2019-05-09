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

class Payload implements ClassToMappingInterface
{
	private $header;
	private $body;
	private $bodyAsList;

	/**
	 * @return array
	 */
	public function getProperties(): array
	{
		return [];
	}

	/**
     * Payload constructor.
     */
	public function __construct()
	{
		$this->header = new Header();
	}

	/**
	 * @param AbstractQueueBody $queueBody
	 * @return Payload
	 */
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
	public function getBody()
	{
		return $this->body;
	}

    /**
     * @return AbstractList|null
     */
	public function getBodyAsList():? AbstractList
    {
        return $this->bodyAsList;
    }

    /**
     * @param AbstractList $bodyAsList
     * @return AbstractList
     */
    public function setBodyAsList(AbstractList $bodyAsList): AbstractList
    {
        return $this->bodyAsList = $bodyAsList;
    }

}