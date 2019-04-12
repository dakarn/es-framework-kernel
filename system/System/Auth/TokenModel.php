<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 08.10.2018
 * Time: 14:59
 */

namespace System\Auth;

use ObjectMapper\ClassToMappingInterface;

class TokenModel implements ClassToMappingInterface
{
	/**
	 * @var string
	 */
	private $access = '';

	/**
	 * @var string
	 */
	private $refresh = '';

	/**
	 * @var int
	 */
	private $userId = 0;

	/**
	 * @var string
	 */
	private $created = '';

	/**
	 * @var string
	 */
	private $expire = '';

	/**
	 * TokenModel constructor.
	 * @param array $props
	 */
	public function __construct(array $props = [])
	{
		if (empty($props)) {
			return;
		}

		$this->access   = $props['access'];
		$this->refresh  = $props['refresh'];
		$this->userId   = $props['userId'];
		$this->created  = $props['created'];
		$this->expire   = $props['expire'];
	}

	/**
	 * @param string $access
	 */
	public function setAccess(string $access): void
	{
		$this->access = $access;
	}

	/**
	 * @param string $refresh
	 */
	public function setRefresh(string $refresh): void
	{
		$this->refresh = $refresh;
	}

	/**
	 * @param int $userId
	 */
	public function setUserId(int $userId): void
	{
		$this->userId = $userId;
	}

	/**
	 * @param string $created
	 */
	public function setCreated(string $created): void
	{
		$this->created = $created;
	}

	/**
	 * @param string $expire
	 */
	public function setExpire(string $expire): void
	{
		$this->expire = $expire;
	}

	/**
	 * @return string
	 */
	public function getAccess(): string
	{
		return $this->access;
	}

	/**
	 * @return string
	 */
	public function getRefresh(): string
	{
		return $this->refresh;
	}

	/**
	 * @return int
	 */
	public function getUserId(): int
	{
		return $this->userId;
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
	public function getExpire(): string
	{
		return $this->expire;
	}
}