<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 30.04.2018
 * Time: 15:52
 */

namespace RedisQueue;

interface QueueInterface
{
	/**
	 * @param string $name
	 * @return Queue
	 */
	public function setName(string $name): Queue;

	/**
	 * @return string
	 */
	public function getName(): string;
}