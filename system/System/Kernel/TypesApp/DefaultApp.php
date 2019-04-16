<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 02.10.2018
 * Time: 1:21
 */

namespace System\Kernel\TypesApp;

class DefaultApp extends AbstractApplication
{
	public function customOutputError(\Throwable $e)
	{

	}

	public function setupClass()
	{

	}

    /**
     * @throws \Exception\FileException
     */
	public function run()
	{
		$this->env = self::ENV_DEV;
		$this->applicationType = self::APP_TYPE_CONSOLE;

		$this->runInternal();
	}

	public function terminate()
	{

	}
}