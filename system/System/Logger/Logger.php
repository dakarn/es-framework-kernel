<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 08.03.2018
 * Time: 15:20
 */

namespace System\Logger;

class Logger extends AbstractLogger implements LoggerInterface
{
	public function info(string $message)
	{
		$this->getStrategy()->addLog(LogLevel::INFO, $message);
	}

	public function error(string $message)
	{
		$this->getStrategy()->addLog(LogLevel::ERROR, $message);
	}

	public function notice(string $message)
	{
		$this->getStrategy()->addLog(LogLevel::NOTICE, $message);
	}

	public function emergency(string $message)
	{
		$this->getStrategy()->addLog(LogLevel::EMERGENCY, $message);
	}

	public function critical(string $message)
	{
		$this->getStrategy()->addLog(LogLevel::CRITICAL, $message);
	}

	public function warning(string $message)
	{
		$this->getStrategy()->addLog(LogLevel::WARNING, $message);
	}

	public function alert(string $message)
	{
		$this->getStrategy()->addLog(LogLevel::ALERT, $message);
	}
}