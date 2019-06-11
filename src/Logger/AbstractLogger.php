<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 08.03.2018
 * Time: 17:29
 */

namespace ES\Kernel\Logger;

class AbstractLogger
{
	/**
	 * @var LoggerStorageInterface
	 */
	private $loggerStorage;

	/**
	 * @return LoggerStorageInterface
	 */
	public function getLoggerStorage(): LoggerStorageInterface
	{
		if (!$this->loggerStorage instanceof LoggerStorageInterface) {
			$this->loggerStorage = new LoggerKafkaQueue();
		}

		return $this->loggerStorage;
	}

	/**
	 * @param string $level
	 * @param string $message
	 */
	public function log(string $level, string $message = '')
	{
		if (!\method_exists($this, $level)) {
			throw new \InvalidArgumentException('This is level of log invalid!');
		}

		$this->$level($message);
	}
}