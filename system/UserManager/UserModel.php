<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 23.04.2018
 * Time: 19:48
 */

namespace UserManager;

class UserModel
{
	/**
	 * @var int
	 */
	private $userId;

	/**
	 * @var int
	 */
	private $externalId;

	/**
	 * @var string
	 */
	private $login;

	/**
	 * @var string
	 */
	private $email;

	/**
	 * @var string
	 */
	private $created;

	/**
	 * @var string
	 */
	private $modified;

	/**
	 * @return string
	 */
	public function getLogin(): string
	{
		return $this->login;
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
	public function getModified(): string
	{
		return $this->modified;
	}

	/**
	 * @return int
	 */
	public function getUserId(): int
	{
		return $this->userId;
	}

	/**
	 * @return int
	 */
	public function getExternalId(): int
	{
		return $this->externalId;
	}

	/**
	 * @return string
	 */
	public function getEmail(): string
	{
		return $this->email;
	}

	/**
	 * @param string $login
	 * @return UserModel
	 */
	public function setLogin(string $login): UserModel
	{
		$this->login = $login;
		return $this;
	}

	/**
	 * @param string $created
	 * @return UserModel
	 */
	public function setCreated(string $created): UserModel
	{
		$this->created = $created;
		return $this;
	}

	/**
	 * @param string $modified
	 * @return UserModel
	 */
	public function setModified(string $modified): UserModel
	{
		$this->modified = $modified;
		return $this;
	}

	/**
	 * @param string $email
	 * @return UserModel
	 */
	public function setEmail(string $email): UserModel
	{
		$this->email = $email;
		return $this;
	}

	/**
	 * @param string $userId
	 * @return UserModel
	 */
	public function setUserId(string $userId): UserModel
	{
		$this->userId = $userId;
		return $this;
	}

	/**
	 * @param string $externalId
	 * @return UserModel
	 */
	public function setExternalId(string $externalId): UserModel
	{
		$this->externalId = $externalId;
		return $this;
	}
}