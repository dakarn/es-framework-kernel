<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 31.05.2019
 * Time: 21:37
 */

namespace ES\Kernel\Helper;

use ES\Kernel\System\Database\Schema\MySQL\MySQLDatabases;
use ES\Kernel\System\Database\Schema\PgSQL\PostgresDatabases;

class StorageObjects
{
	/**
	 * @var array
	 */
	private static $objects = [];

	/**
	 * @return MySQLDatabases
	 */
	public static function getMySQLDatabases(): MySQLDatabases
	{
		return self::get(MySQLDatabases::class);
	}

	/**
	 * @return PostgresDatabases
	 */
	public static function getPostgresDatabases(): PostgresDatabases
	{
		return self::get(PostgresDatabases::class);
	}

	/**
	 * @param string $objectName
	 * @return mixed
	 */
	private static function get(string $objectName)
	{
		if (!isset(self::$objects[$objectName])) {
			self::$objects[$objectName] = new $objectName();
		}

		return self::$objects[$objectName];
	}
}