<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 05.04.2018
 * Time: 20:58
 */

namespace Helper;

final class self
{
	/**
	 * @var string
	 */
	private $file;

	/**
	 * File constructor.
	 * @param string $file
	 */
	public function __construct(string $file)
	{
		$this->file = $file;
	}

	/**
	 * @return int
	 */
	public function getFilesize(): int
	{
		return \filesize($this->file);
	}

	/**
	 * @return bool|string
	 */
	public function getContent(): string
	{
		return \file_get_contents($this->file);
	}

}