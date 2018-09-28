<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 01.04.2018
 * Time: 23:52
 */

namespace Queue;

interface QueueInterface
{
	public function setName(string $name): Queue;

	public function setData(string $name): Queue;

	public function setRoutingKey(string $routingKey): Queue;

	public function setType(string $type): Queue;

	public function setFlags(string $flags): Queue;

	public function setExchangeName(string $exchangeName): Queue;

	public function getName(): string;

	public function getRoutingKey(): string;

	public function getType(): string;

	public function getData(): string;

	public function getFlags(): string;

	public function getExchangeName(): string;
}