<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 05.04.2018
 * Time: 20:58
 */

namespace Helper;

final class File
{
	private $file;

	public function __construct(string $file)
	{
		$this->file = $file;
	}

	public function getFilesize(): int
	{
		return filesize($this->file);
	}

	public function getContent()
	{
		return file_get_contents($this->file);
	}

}