<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 04.05.2019
 * Time: 0:05
 */

namespace Kafka\Message;

use ObjectMapper\ClassToMappingInterface;

class Header implements ClassToMappingInterface
{
	private $hash;
	private $time;
	private $topicName;

	/**
	 * @return mixed
	 */
	public function getHash()
	{
		return $this->hash;
	}

	/**
	 * @param mixed $hash
	 */
	public function setHash($hash): void
	{
		$this->hash = $hash;
	}

	/**
	 * @return mixed
	 */
	public function getTime()
	{
		return $this->time;
	}

	/**
	 * @param mixed $time
	 */
	public function setTime($time): void
	{
		$this->time = $time;
	}

	/**
	 * @return mixed
	 */
	public function getTopicName()
	{
		return $this->topicName;
	}

	/**
	 * @param mixed $topicName
	 */
	public function setTopicName($topicName): void
	{
		$this->topicName = $topicName;
	}
}