<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 08.03.2018
 * Time: 15:11
 */

namespace System\Kernel;

use System\Registry;

class ShutdownScript
{
	public static function run()
	{
		Registry::get(Registry::APP)->terminate();
	}
}