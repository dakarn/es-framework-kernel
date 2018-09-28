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
	 * @param string $type
	 * @return QueueModel
	 */
	public function setType(string $type): QueueModel
	{
		$this->type = $type;
		return $this;
	}

	/**
	 * @param string $data
	 * @return QueueModel
	 */
	public function setData(string $data): QueueModel
	{
		$this->dataForSend = $data;
		return $this;
	}

	/**
	 * @param array $data
	 * @return QueueModel
	 */
	public function setDataAsArray(array $data): QueueModel
	{
		$this->dataForSend = json_encode($data, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
		return $this;
	}

	/**
	 * @param string $exchangeName
	 * @return QueueModel
	 */
	public function setExchangeName(string $exchangeName): QueueModel
	{
		$this->exchangeName = $exchangeName;
		return $this;
	}

	/**
	 * @param string $flags
	 * @return QueueModel
	 */
	public function setFlags(string $flags): QueueModel
	{
		$this->flags = $flags;
		return $this;
	}

	/**
	 * @param string $name
	 * @return QueueModel
	 */
	public function setName(string $name): QueueModel
	{
		$this->name = $name;
		return $this;
	}

	/**
	 * @param string $routingKey
	 * @return QueueModel
	 */
	public function setRoutingKey(string $routingKey): QueueModel
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
	public function getName(): string
	{
		return $this->name;
	}

}