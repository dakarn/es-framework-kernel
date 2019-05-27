<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 04.05.2019
 * Time: 0:05
 */

namespace ES\Kernel\Kafka\Message;

use ES\Kernel\ObjectMapper\ClassToMappingInterface;

class Header implements ClassToMappingInterface, HeaderInterface
{
	private $hash;
	private $time;
	private $topicName;
	private $attempts;

	public function getProperties(): array
	{
		return [
			'hash',
			'time',
			'topicName',
            'attempts'
		];
	}

    /**
     * @return mixed
     */
    public function getAttempts()
    {
        return $this->attempts;
    }

    /**
     * @param mixed $attempts
     */
    public function setAttempts($attempts): void
    {
        $this->attempts = $attempts;
    }

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