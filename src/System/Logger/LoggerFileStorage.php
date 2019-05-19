<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 08.03.2018
 * Time: 15:30
 */

namespace ES\Kernel\System\Logger;

class LoggerFileStorage extends AbstractLoggerStorage implements LoggerStorageInterface
{
	/**
	 *
	 */
	public function releaseLogs(): void
	{
		foreach ($this->logs as $log) {
			\error_log('Log' . $log['level'] . ' - ' . $log['time'] . ' - ' . $log['message']);
		}
	}
}