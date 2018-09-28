<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 28.03.2018
 * Time: 2:25
 */

namespace System;

use Exception\KernelException;

class AppObjectMemento
{
	const APP_EVENT    = 'AppEvent';
	const APP_KERNEL   = 'AppKernel';
	const ROUTERS      = 'Routers';
	const APP          = 'APP';

	private static $listObject = [];

	public static function get(string $class)
	{
		if (!empty(self::$listObject[$class])) {
			return self::$listObject[$class];
		}

		throw KernelException::notFoundInAppMemento([self::$listObject[$class]]);
	}

	public static function has(string $class): bool
	{
		return !empty(self::$listObject[$class]) ?: false;
	}

	public static function set(string $name, $class): bool
	{
		self::$listObject[$name] = $class;
		return true;
	}
}