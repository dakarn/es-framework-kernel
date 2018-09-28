<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 01.04.2018
 * Time: 0:49
 */

namespace RedisQueue;

class Queue implements QueueInterface
{
	/**
	 * @var string
	 */
	private $name;

	/**
	 * @var string
	 */
	private $routing;

	/**
	 * @param string $name
	 * @return Queue
	 */
	public function setName(string $name): Queue
	{
		$this->name = $name;
		return $this;
	}

	/**
	 * @return string
	 */
	public function getName(): string
	{
		return $this->name;
	}

	public function setRoutingKey(string $routing): Queue
	{
		$this->routing = $routing;
		return $this;
	}

	/**
	 * @return string
	 */
	public function getRoutingKey(): string
	{
		return $this->routing;
	}

}