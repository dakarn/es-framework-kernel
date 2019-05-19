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
	const MYSQL = 'MySQL';

	const PGSQL = 'PgSQL';

	const ORACLE = 'Oracle';

	const MSSQL = 'MSSQL';

	const READ = 'read';

	const WRITE = 'write';

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
	 * @return DBAdapterInterface
	 * @throws \Exception
	 */
	public static function MySQLAdapter(): DBAdapterInterface
	{
		if (!isset(self::$adapters[self::MYSQL])) {
			self::$adapters[self::MYSQL] = new DBAdapter(new MySQLAdapter(new MySQL()));
		}

	    return self::$adapters[self::MYSQL];
	}

	/**
	 * @return DBAdapterInterface
	 * @throws \Exception
	 */
	public static function PgSQLAdapter(): DBAdapterInterface
	{
		if (!isset(self::$adapters[self::PGSQL])) {
			self::$adapters[self::PGSQL] = new DBAdapter(new PgSQLAdapter(new PgSQL()));
		}

		return self::$adapters[self::MYSQL];
	}
}