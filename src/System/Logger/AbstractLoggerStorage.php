<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 27.03.2019
 * Time: 21:52
 */

namespace ES\Kernel\System\Logger;

abstract class AbstractLoggerStorage
{
	/**
	 * @var array
	 */
	protected $logs = [];

	/**
	 * @param string $level
	 * @param string $message
	 * @return AbstractLoggerStorage
	 */
	public function addLog(string $level, string $message): self
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

	abstract public function releaseLogs();
}