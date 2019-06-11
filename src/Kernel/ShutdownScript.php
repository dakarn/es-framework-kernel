<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 08.03.2018
 * Time: 15:11
 */

namespace ES\Kernel\Kernel;

use ES\Kernel\System\ES;

class ShutdownScript
{
	/**
	 * @throws \ES\Kernel\Exception\KernelException
	 */
	public static function run()
	{
		ES::get(ES::APP)->terminate();
	}
}