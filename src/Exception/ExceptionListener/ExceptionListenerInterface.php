<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 18.04.2018
 * Time: 19:33
 */

namespace ES\Kernel\Exception\ExceptionListener;

interface ExceptionListenerInterface
{
	public function run(\Throwable $e);
}