<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 02.05.2019
 * Time: 18:31
 */

namespace Kafka;

class ConfigureConnect implements ConfigureConnectInterface
{
	/**
	 * @var array
	 */
	private $brokers;
	private $group;
	private $topic;

	public function __construct(array $brokers, string $topic, string $group)
	{
		$this->brokers = $brokers;
		$this->topic   = $topic;
		$this->group   = $group;
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