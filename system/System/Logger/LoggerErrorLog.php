<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 08.03.2018
 * Time: 15:30
 */

namespace System\Logger;

use Traits\SingletonTrait;

class LoggerErrorLog implements LoggerStorageInterface
{
	use SingletonTrait;

	/**
	 * @var array
	 */
	private $logs = [];

	/**
	 * @param string $level
	 * @param string $message
	 * @return LoggerStorageInterface
	 */
	public function addLog(string $level, string $message): LoggerStorageInterface
	{
		$this->logs[] = [
			'time'    => \date('d.m.y H:i:s', \time()),
			'level'   => $level,
			'message' => $message
		];

		return $this;
	}

	/**
	 * @return array
	 */
	public function getLogs(): array
	{
		return $this->logs;
	}

	/**
	 *
	 */
	public function releaseLog(): void
	{
		foreach ($this->logs as $log) {
			\error_log('Log' . $log['level'] . ' - ' . $log['time'] . ' - ' . $log['message']);
		}
	}
}