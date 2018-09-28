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
    /**
     * @var string
     */
	private $host;

    /**
     * @var string
     */
	private $database;

    /**
     * @var string
     */
	private $user;

    /**
     * @var string
     */
	private $password;

    /**
     * @var string
     */
	private $charset;

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