<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 07.10.2018
 * Time: 17:20
 */

namespace System\Auth;

use ObjectMapper\ClassToMappingInterface;

class ClientApp implements ClassToMappingInterface
{
	/**
	 * @var mixed|string
	 */
	private $clientId = '';

	/**
	 * @var mixed|string
	 */
	private $clientSecret = '';

	/**
	 * @var mixed|string
	 */
	private $description = '';

	/**
	 * @var int|mixed
	 */
	private $accessTTL = 0;

	/**
	 * @var int|mixed
	 */
	private $refreshTTL = 0;

	/**
	 * @var mixed|string
	 */
	private $created = '';

	/**
	 * @var mixed|string
	 */
	private $site = '';

	/**
	 * @var mixed|string
	 */
	private $type = '';

	/**
	 * @var array|mixed
	 */
	private $allowIps = [];

	public function getProperties(): array
	{
		return [];
	}

	/**
	 * @return string
	 */
	public function getType(): string
	{
		return $this->type;
	}

	/**
	 * @param mixed|string $clientId
	 */
	public function setClientId($clientId): void
	{
		$this->clientId = $clientId;
	}

	/**
	 * @param mixed|string $clientSecret
	 */
	public function setClientSecret($clientSecret): void
	{
		$this->clientSecret = $clientSecret;
	}

	/**
	 * @param mixed|string $description
	 */
	public function setDescription($description): void
	{
		$this->description = $description;
	}

	/**
	 * @param int|mixed $accessTTL
	 */
	public function setAccessTTL($accessTTL): void
	{
		$this->accessTTL = $accessTTL;
	}

	/**
	 * @param int|mixed $refreshTTL
	 */
	public function setRefreshTTL($refreshTTL): void
	{
		$this->refreshTTL = $refreshTTL;
	}

	/**
	 * @param mixed|string $created
	 */
	public function setCreated($created): void
	{
		$this->created = $created;
	}

	/**
	 * @param mixed|string $site
	 */
	public function setSite($site): void
	{
		$this->site = $site;
	}

	/**
	 * @param mixed|string $type
	 */
	public function setType($type): void
	{
		$this->type = $type;
	}

	/**
	 * @param array|mixed $allowIps
	 */
	public function setAllowIps($allowIps): void
	{
		$this->allowIps = \json_decode($allowIps, true);
	}

	/**
	 * @return string
	 */
	public function getClientId(): string
	{
		return $this->clientId;
	}

	/**
	 * @return string
	 */
	public function getClientSecret(): string
	{
		return $this->clientSecret;
	}

	/**
	 * @return array
	 */
	public function getAllowIps(): array
	{
		return $this->allowIps;
	}

	/**
	 * @return string
	 */
	public function getDescription(): string
	{
		return $this->description;
	}

	/**
	 * @return int
	 */
	public function getAccessTTL(): int
	{
		return $this->accessTTL;
	}

	/**
	 * @return int
	 */
	public function getRefreshTTL(): int
	{
		return $this->refreshTTL;
	}

	/**
	 * @return string
	 */
	public function getCreated(): string
	{
		return $this->created;
	}

	/**
	 * @return string
	 */
	public function getSite(): string
	{
		return $this->site;
	}
}