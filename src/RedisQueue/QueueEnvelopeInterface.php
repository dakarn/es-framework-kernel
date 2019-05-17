<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 30.04.2018
 * Time: 15:53
 */

namespace RedisQueue;

interface QueueEnvelopeInterface
{
	public function __construct();

	/**
	 * @param string $body
	 * @return QueueEnvelope
	 */
	public function setBody(string $body): QueueEnvelope;

	/**
	 * @return string
	 */
	public function getBody(): string;

	/**
	 * @return string
	 */
	public function getQueueName(): string;

	/**
	 * @return bool
	 */
	public function isReceived(): bool;
}