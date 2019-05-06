<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 01.04.2018
 * Time: 0:49
 */

namespace QueueManager;

class QueueModel implements QueueModelInterface
{
	/**
	 * @var string
	 */
	private $type;

	/**
	 * @var string
	 */
	private $dataForSend = '';

	/**
	 * @var string
	 */
	private $name;

	/**
	 * @var string
	 */
	private $exchangeName;

	/**
	 * @var int
	 */
	private $flags;

	/**
	 * @var string
	 */
	private $routingName;

	/**
	 * @var string
	 */
	private $groupId;

	/**
	 * @return string
	 */
	public function getGroupId(): string
	{
		return $this->groupId;
	}

	/**
	 * @param string $groupId
	 * @return QueueModelInterface
	 */
	public function setGroupId(string $groupId): QueueModelInterface
	{
		$this->groupId = $groupId;

		return $this;
	}

	/**
	 * @param string $type
	 * @return QueueModelInterface
	 */
	public function setType(string $type): QueueModelInterface
	{
		$this->type = $type;
		return $this;
	}

	/**
	 * @param string $data
	 * @return QueueModelInterface
	 */
	public function setData(string $data): QueueModelInterface
	{
		$this->dataForSend = $data;
		return $this;
	}

	/**
	 * @param array $data
	 * @return QueueModelInterface
	 */
	public function setDataAsArray(array $data): QueueModelInterface
	{
		$this->dataForSend = json_encode($data, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
		return $this;
	}

	/**
	 * @param string $exchangeName
	 * @return QueueModelInterface
	 */
	public function setExchangeName(string $exchangeName): QueueModelInterface
	{
		$this->exchangeName = $exchangeName;
		return $this;
	}

	/**
	 * @param string $flags
	 * @return QueueModelInterface
	 */
	public function setFlags(string $flags): QueueModelInterface
	{
		$this->flags = $flags;
		return $this;
	}

	/**
	 * @param string $name
	 * @return QueueModelInterface
	 */
	public function setTopicName(string $name): QueueModelInterface
	{
		$this->name = $name;
		return $this;
	}

	/**
	 * @param string $routingKey
	 * @return QueueModelInterface
	 */
	public function setRoutingKey(string $routingKey): QueueModelInterface
	{
		$this->routingName = $routingKey;
		return $this;
	}

	/**
	 * @return string
	 */
	public function getType(): string
	{
		return $this->type;
	}

	/**
	 * @return string
	 */
	public function getData(): string
	{
		return $this->dataForSend;
	}

	/**
	 * @return string
	 */
	public function getExchangeName(): string
	{
		return $this->exchangeName;
	}

	/**
	 * @return string
	 */
	public function getFlags(): string
	{
		return $this->flags;
	}

	/**
	 * @return string
	 */
	public function getRoutingKey(): string
	{
		return $this->routingName;
	}

	/**
	 * @return string
	 */
	public function getTopicName(): string
	{
		return $this->name;
	}

}