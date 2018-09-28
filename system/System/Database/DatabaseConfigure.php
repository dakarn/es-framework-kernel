<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 17.03.2018
 * Time: 20:14
 */

namespace System\Database;

class DatabaseConfigure
{
	private $host;

	private $database;

	private $user;

	private $password;

	private $charset;

	public function __construct(array $config)
	{
		$config = $config['DEV'];

		$this->host     = $config['host'];
		$this->database = $config['database'];
		$this->user     = $config['user'];
		$this->password = $config['password'];
		$this->charset  = $config['charset'];
	}

	public function getHost(): string
	{
		return $this->host;
	}

	public function getUser(): string
	{
		return $this->user;
	}

	public function getPassword(): string
	{
		return $this->password;
	}

	public function getCharset(): string
	{
		return $this->charset;
	}

	public function getDatabase(): string
	{
		return $this->database;
	}
}