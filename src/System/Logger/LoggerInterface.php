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
	/**
	 * @param string $message
	 * @return mixed
	 */
	public function notice(string $message);

	/**
	 * @param string $message
	 * @return mixed
	 */
	public function warning(string $message);

	/**
	 * @param string $message
	 * @return mixed
	 */
	public function info(string $message);

	/**
	 * @param string $message
	 * @return mixed
	 */
	public function emergency(string $message);

	/**
	 * @param string $message
	 * @return mixed
	 */
	public function critical(string $message);

	/**
	 * @param string $message
	 * @return mixed
	 */
	public function alert(string $message);

	/**
	 * @param string $message
	 * @return mixed
	 */
	public function error(string $message);

	/**
	 * @param string $level
	 * @param string $message
	 * @return mixed
	 */
	public function log(string $level, string $message);
}