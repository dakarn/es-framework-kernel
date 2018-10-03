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
	/**
	 * @var null
	 */
	private $strategy = null;

	/**
	 * @return LoggerStorageInterface
	 */
	protected function getStrategy(): LoggerStorageInterface
	{
		if ($this->strategy === null) {
			$this->strategy = LoggerElasticSearch::create();
		}

		return $this->strategy;
	}

	/**
	 * @param string $level
	 * @param string $message
	 */
	public function log(string $level, string $message = '')
	{
		if (!method_exists($this, $level)) {
			throw new \InvalidArgumentException('This is level of log invalid!');
		}

		$this->$level($message);
	}
}