<?php

namespace ES\Kernel\System\Database;

use ES\Kernel\System\Database\Adapter\DBAdapter;
use ES\Kernel\System\Database\Adapter\DBAdapterInterface;
use ES\Kernel\System\Database\Adapter\MySQLAdapter;
use ES\Kernel\System\Database\Adapter\PgSQLAdapter;
use ES\Kernel\System\Database\Connector\MySQL;
use ES\Kernel\System\Database\Connector\PgSQL;

class DB
{
	const MYSQL  = 'MySQL';
	const PGSQL  = 'PgSQL';
	const ORACLE = 'Oracle';
	const MSSQL  = 'MSSQL';

	const READ   = 'read';
	const WRITE  = 'write';

	/**
	 * @var DBAdapterInterface[]
	 */
	private static $adapters = [];

    /**
     * DB constructor.
     */
	private function __construct()
	{
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
		if (!isset(self::$adapters[self::MYSQL . $database])) {
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
		if (!isset(self::$adapters[self::PGSQL. $database])) {
			self::$adapters[self::PGSQL . $database] = new DBAdapter(new PgSQLAdapter(new PgSQL($database)));
		}

		return self::$adapters[self::PGSQL . $database];
	}
}