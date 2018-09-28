<?php

namespace System\Database;

class DB
{
	private static $connect;

	/**
	 * @var DatabaseConfigure
	 */
	private static $configure;

	private function __construct()
	{
	}

	private function __clone()
	{
	}

	public static function setConfigure(DatabaseConfigure $configure)
	{
		self::$configure = $configure;
	}

	public static function create(): \mysqli
	{
		if (!self::$connect instanceof \mysqli) {
			self::$connect = new \mysqli(
				self::$configure->getHost(),
				self::$configure->getUser(),
				self::$configure->getPassword(),
				self::$configure->getDatabase()
			);
			self::$connect->set_charset(self::$configure->getCharset());
		}

		return self::$connect;
	}


}