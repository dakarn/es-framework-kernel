<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 08.03.2018
 * Time: 15:30
 */

namespace System\Logger;

use Traits\SingletonTrait;

class LoggerStorage implements LoggerStorageInterface
{
	use SingletonTrait;

	private $log = [];

	public function addLog(string $level, string $message): LoggerStorageInterface
	{
		$this->log[] = [
			'time'    => date('d.m.y H:i:s', time()),
			'level'   => $level,
			'message' => $message
		];

		return $this;
	}

	public function getLog(): array
	{
		return $this->log;
	}

	public function releaseLog(): void
	{
		foreach ($this->log as $log) {
			error_log('Log' . $log['level'] . ' - ' . $log['time'] . ' - ' . $log['message']);
		}
	}
}