<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 01.04.2018
 * Time: 23:52
 */

namespace QueueManager;

interface QueueModelInterface
{
	/**
	 * @param string $name
	 * @return QueueModel
	 */
	public function setName(string $name): QueueModel;

	/**
	 * @param string $name
	 * @return QueueModel
	 */
	public function setData(string $name): QueueModel;

	/**
	 * @param string $routingKey
	 * @return QueueModel
	 */
	public function setRoutingKey(string $routingKey): QueueModel;

	/**
	 * @param string $type
	 * @return QueueModel
	 */
	public function setType(string $type): QueueModel;

	/**
	 * @param string $flags
	 * @return QueueModel
	 */
	public function setFlags(string $flags): QueueModel;

	/**
	 * @param string $exchangeName
	 * @return QueueModel
	 */
	public function setExchangeName(string $exchangeName): QueueModel;

	/**
	 * @return string
	 */
	public function getName(): string;

	/**
	 * @return string
	 */
	public function getRoutingKey(): string;

	/**
	 * @return string
	 */
	public function getType(): string;

	/**
	 * @return string
	 */
	public function getData(): string;

	/**
	 * @return string
	 */
	public function getFlags(): string;

	/**
	 * @return string
	 */
	public function getExchangeName(): string;
}