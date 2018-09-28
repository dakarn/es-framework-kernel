<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 08.03.2018
 * Time: 17:29
 */

namespace System\Logger;

class AbstractLogger
{
	private $strategy = null;

	protected function getStrategy(): LoggerStorageInterface
	{
		if ($this->strategy === null) {
			$this->strategy = LoggerStorage::create();
		}

		return $this->strategy;
	}

	public function log(string $level, string $message = '')
	{
		if (!method_exists($this, $level)) {
			throw new \InvalidArgumentException('This is level of log invalid!');
		}

		$this->$level($message);
	}
}