<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 01.04.2018
 * Time: 0:49
 */
namespace Queue;

class Queue implements QueueInterface
{
	private $type;

	private $dataForSend;

	private $name;

	private $exchangeName;

	private $flags;

	private $routingName;

	public function setType(string $type): Queue
	{
		$this->type = $type;
		return $this;
	}

	public function setData(string $data): Queue
	{
		$this->dataForSend = $data;
		return $this;
	}

	public function setDataAsArray(array $data): Queue
	{
		$this->dataForSend = json_encode($data, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
		return $this;
	}

	public function setExchangeName(string $exchangeName): Queue
	{
		$this->exchangeName = $exchangeName;
		return $this;
	}

	public function setFlags(string $flags): Queue
	{
		$this->flags = $flags;
		return $this;
	}

	public function setName(string $name): Queue
	{
		$this->name = $name;
		return $this;
	}

	public function setRoutingKey(string $routingKey): Queue
	{
		$this->routingName = $routingKey;
		return $this;
	}

	public function getType(): string
	{
		return $this->type;
	}

	public function getData(): string
	{
		return $this->dataForSend;
	}

	public function getExchangeName(): string
	{
		return $this->exchangeName;
	}

	public function getFlags(): string
	{
		return $this->flags;
	}

	public function getRoutingKey(): string
	{
		return $this->routingName;
	}

	public function getName(): string
	{
		return $this->name;
	}

}