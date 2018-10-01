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
	/**
	 * @throws \Exception\FileException
	 */
	public function run()
	{
		$this->env = 'dev';
		$this->applicationType = 'Console';

		$this->runInternal();
	}

	public function terminate()
	{

	}
}