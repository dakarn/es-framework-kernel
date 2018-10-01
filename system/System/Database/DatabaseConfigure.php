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
		$this->host     = $config['read']['host'];
		$this->database = $config['read']['database'];
		$this->user     = $config['read']['user'];
		$this->password = $config['read']['password'];
		$this->charset  = $config['read']['charset'];
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