<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 02.05.2019
 * Time: 18:31
 */

namespace Kafka;

class ConfigConnection implements ConfigureConnectInterface
{
	/**
	 * @var array
	 */
	private $brokers;

	/**
	 * @var string
	 */
	private $group;

	/**
	 * @var string
	 */
	private $topic;

	/**
	 * @param array $brokers
	 */
	public function setBrokers(array $brokers): void
	{
		$this->brokers = $brokers;
	}

	/**
	 * @param string $group
	 */
	public function setGroup(string $group): void
	{
		$this->group = $group;
	}

	/**
	 * @param string $topic
	 */
	public function setTopic(string $topic): void
	{
		$this->topic = $topic;
	}

	/**
	 * @return string
	 */
	public function getGroup(): string
	{
		return $this->group;
	}

	/**
	 * @return array
	 */
	public function getBrokers(): array
	{
		return $this->brokers;
	}

	/**
	 * @return string
	 */
	public function getTopic(): string
	{
		return $this->topic;
	}
}