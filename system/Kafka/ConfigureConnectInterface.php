<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 02.05.2019
 * Time: 20:49
 */

namespace Kafka;

interface ConfigureConnectInterface
{
	/**
	 * @return string
	 */
	public function getGroup(): string;

	/**
	 * @return array
	 */
	public function getBrokers(): array;

	/**
	 * @return string
	 */
	public function getTopic(): string;
}