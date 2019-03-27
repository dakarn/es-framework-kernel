<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 08.03.2018
 * Time: 15:30
 */

namespace System\Logger;

use Traits\SingletonTrait;

class LoggerErrorLog extends AbstractLoggerStorage implements LoggerStorageInterface
{
	use SingletonTrait;

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