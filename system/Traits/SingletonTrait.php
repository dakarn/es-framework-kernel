<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 11.03.2018
 * Time: 0:51
 */

namespace Traits;

trait SingletonTrait
{
	protected static $instance;

	public function __construct()
	{
	}

	public function __clone()
	{
	}

	public static function create(): self
	{
		if (!self::$instance instanceof static) {
			self::$instance = new static;
		}

		return static::$instance;
	}
}