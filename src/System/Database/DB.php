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
     * DB constructor.
     * @throws \ES\Kernel\Exception\FileException
     */
	private function __construct()
	{
        self::$dbConfig = Config::get('db');
	}

    /**
     * @return void
     */
	private function __clone()
	{
	}

	/**
	 * @param string $database
	 * @return DBAdapterInterface
	 * @throws \Exception
	 */
	public static function MySQLAdapter(string $database): DBAdapterInterface
	{
		if (!self::alreadyHasAdapter(self::MYSQL . $database)) {
            DbConfig::create()->setConfigure(DB::MYSQL, new DatabaseConfigure(self::$dbConfig[self::MYSQL][$database]));
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
            DbConfig::create()->setConfigure(DB::PGSQL, new DatabaseConfigure(self::$dbConfig[self::PGSQL][$database]));
			self::$adapters[self::PGSQL . $database] = new DBAdapter(new PgSQLAdapter(new PgSQL($database)));
		}

		return self::$adapters[self::PGSQL . $database];
	}

    /**
     * @param string $key
     * @return bool
     */
	private static function alreadyHasAdapter(string $key): bool
    {
        return !isset(self::$adapters[$key]);
    }
}