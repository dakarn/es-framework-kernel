<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 08.03.2018
 * Time: 15:16
 */

namespace System\Logger;

interface LoggerInterface
{
	public function notice(string $message);

	public function warning(string $message);

	public function info(string $message);

	public function emergency(string $message);

	public function critical(string $message);

	public function alert(string $message);

	public function error(string $message);

	public function log(string $level, string $message);
}