<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 30.04.2018
 * Time: 15:27
 */

namespace RedisQueue;

class QueueEnvelope implements QueueEnvelopeInterface
{
	/**
	 * @var string
	 */
	private $body = '';

	/**
	 * @var string
	 */
	private $idHash = '';

	/**
	 * QueueEnvelope constructor.
	 */
	public function __construct()
	{
	}

	/**
	 * @param string $body
	 * @return QueueEnvelope
	 */
	public function setBody(string $body): QueueEnvelope
	{
		$this->body = $body;
		return $this;
	}

	/**
	 * @return string
	 */
	public function getBody(): string
	{
		return $this->body;
	}

	/**
	 * @return string
	 */
	public function getIdHash(): string
	{
		return $this->idHash;
	}

	/**
	 * @param string $idHash
	 * @return string
	 */
	public function setIdHash(string $idHash): string
	{
		$this->idHash = $idHash;
		return $this;
	}

	/**
	 * @return string
	 */
	public function getQueueName(): string
	{
		return '';
	}

	/**
	 * @return bool
	 */
	public function isReceived(): bool
	{
		return !empty($this->body);
	}
}