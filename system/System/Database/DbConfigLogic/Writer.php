<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 03.10.2018
 * Time: 21:11
 */

namespace System\Database\DbConfigLogic;

class Writer
{
	/**
	 * @var string
	 */
	private $host = '';

	/**
	 * @var string
	 */
	private $database = '';

	/**
	 * @var string
	 */
	private $user = '';

	/**
	 * @var string
	 */
	private $password = '';

	/**
	 * @var string
	 */
	private $charset = '';

	/**
	 * @var array|mixed
	 */
	private $writer;

	/**
	 * @var array|mixed
	 */
	private $readers;

	/**
	 * DatabaseConfigure constructor.
	 * @param array $config
	 */
	public function __construct(array $config)
	{
		$this->host     = $config['host'];
		$this->database = $config['database'];
		$this->user     = $config['user'];
		$this->password = $config['password'];
		$this->charset  = $config['charset'];
	}

	public function getWriter(): array
	{
		return $this->writer;
	}

	public function getReaders(): array
	{
		return $this->readers;
	}

	/**
	 * @return string
	 */
	public function getHost(): string
	{
		return $this->host;
	}

	/**
	 * @return string
	 */
	public function getUser(): string
	{
		return $this->user;
	}

	/**
	 * @return string
	 */
	public function getPassword(): string
	{
		return $this->password;
	}

	/**
	 * @return string
	 */
	public function getCharset(): string
	{
		return $this->charset;
	}

	/**
	 * @return string
	 */
	public function getDatabase(): string
	{
		return $this->database;
	}
}