<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 08.03.2018
 * Time: 15:20
 */

namespace ES\Kernel\Logger;

class Logger extends AbstractLogger implements LoggerInterface
{
	/**
	 * @param string $message
	 */
	public function info(string $message)
	{
		$this->getLoggerStorage()->addLog(LogLevel::INFO, $message);
	}

	/**
	 * @param string $message
	 */
	public function error(string $message)
	{
		$this->getLoggerStorage()->addLog(LogLevel::ERROR, $message);
	}

	/**
	 * @param string $message
	 */
	public function notice(string $message)
	{
		$this->getLoggerStorage()->addLog(LogLevel::NOTICE, $message);
	}

	/**
	 * @param string $message
	 */
	public function emergency(string $message)
	{
		$this->getLoggerStorage()->addLog(LogLevel::EMERGENCY, $message);
	}

	/**
	 * @param string $message
	 */
	public function critical(string $message)
	{
		$this->getLoggerStorage()->addLog(LogLevel::CRITICAL, $message);
	}

	/**
	 * @param string $message
	 */
	public function warning(string $message)
	{
		$this->getLoggerStorage()->addLog(LogLevel::WARNING, $message);
	}

	/**
	 * @param string $message
	 */
	public function alert(string $message)
	{
		$this->getLoggerStorage()->addLog(LogLevel::ALERT, $message);
	}
}