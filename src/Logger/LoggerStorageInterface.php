<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 07.04.2018
 * Time: 2:02
 */

namespace ES\Kernel\Logger;

interface LoggerStorageInterface
{
	/**
	 * @param string $level
	 * @param string $message
	 * @return AbstractLoggerStorage
	 */
	public function addLog(string $level, string $message): AbstractLoggerStorage;

	/**
	 * @return array
	 */
	public function getLogs(): array;

	/**
	 *
	 */
	public function releaseLogs(): void;
}