<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 04.05.2019
 * Time: 0:08
 */

namespace Kafka\Message;

use ObjectMapper\ClassToMappingInterface;

class Payload implements ClassToMappingInterface
{
	private $header;
	private $body;

	public function __construct(string $bodyClass)
	{
		$this->header = new Header();
		$this->body   = new $bodyClass();
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
	public function getBody(): AbstractQueueBody
	{
		return $this->body;
	}
}