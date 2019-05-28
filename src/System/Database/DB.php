<?php

namespace ES\Kernel\System\Database;

use ES\Kernel\Configs\Config;
use ES\Kernel\System\Database\Adapter\DBAdapter;
use ES\Kernel\System\Database\Adapter\DBAdapterInterface;
use ES\Kernel\System\Database\Adapter\MySQLAdapter;
use ES\Kernel\System\Database\Adapter\PgSQLAdapter;
use ES\Kernel\System\Database\Connector\MySQL;
use ES\Kernel\System\Database\Connector\PgSQL;
use ES\Kernel\System\Database\DbConfigLogic\DatabaseConfigure;
use ES\Kernel\System\Database\DbConfigLogic\DbConfig;

class DB
{
	const MYSQL  = 'MySQL';
	const PGSQL  = 'PgSQL';
	const ORACLE = 'Oracle';
	const MSSQL  = 'MSSQL';

	const READ   = 'read';
	const WRITE  = 'write';

    /**
     * @var array|mixed|string
     */
	private static $dbConfig = [];

	/**
	 * @var DBAdapterInterface[]
	 */
	private static $adapters = [];

	/**
	 * @param string $database
	 * @return DBAdapterInterface
	 * @throws \Exception
	 */
	public static function MySQLAdapter(string $database): DBAdapterInterface
	{
		if (!self::alreadyHasAdapter(self::MYSQL . $database)) {
			self::initDbConfig(self::MYSQL, $database);
			self::$adapters[self::MYSQL. $database] = new DBAdapter(new MySQLAdapter(new MySQL($database)));
		}

	    return self::$adapters[self::MYSQL . $database];
	}

	/**
	 * @param string $database
	 * @return DBAdapterInterface
	 * @throws \Exception
	 */
	public static function PgSQLAdapter(string $database): DBAdapterInterface
	{
        if (!self::alreadyHasAdapter(self::PGSQL . $database)) {
        	self::initDbConfig(self::PGSQL, $database);
			self::$adapters[self::PGSQL . $database] = new DBAdapter(new PgSQLAdapter(new PgSQL($database)));
		}

		return self::$adapters[self::PGSQL . $database];
	}

	/**
	 * @param string $dbType
	 * @param string $database
	 * @throws \ES\Kernel\Exception\FileException
	 */
	private static function initDbConfig(string $dbType, string $database)
	{
		self::$dbConfig = Config::get('db');
		DbConfig::create()->setConfigure($dbType, new DatabaseConfigure(self::$dbConfig[$dbType][$database]));
	}

    /**
     * @param string $key
     * @return bool
     */
	private static function alreadyHasAdapter(string $key): bool
    {
        return isset(self::$adapters[$key]);
    }
}