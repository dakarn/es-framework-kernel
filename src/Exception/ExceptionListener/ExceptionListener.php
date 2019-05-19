<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 21.04.2018
 * Time: 20:41
 */

namespace ES\Kernel\Exception\ExceptionListener;

use ES\Kernel\Configs\Config;

class ExceptionListener
{
	/**
	 * ExceptionListener constructor.
	 * @param \Throwable $e
	 */
	public function __construct(\Throwable $e)
	{
		//print_r($e->getTrace()[0]);
		//$this->loopHandlers($e);
	}

	/**
	 * @param \Throwable $e
	 * @return void
	 */
	public function loopHandlers(\Throwable $e): void
	{
		$handlers = Config::getExceptionHandlers();

		foreach ($handlers as $handler) {
			if ($handler == $e->getFile()) {
				//$this->runHandler(new $handler, $e);
				return;
			}
		}
	}

	/**
	 * @param ExceptionHandlerInterface $handler
	 * @param \Throwable $e
	 * @return bool
	 */
	public function runHandler(ExceptionHandlerInterface $handler, \Throwable $e): bool
	{
		$handler->run($e);

		return true;
	}
}