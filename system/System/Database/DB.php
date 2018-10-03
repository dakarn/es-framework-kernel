<?php

namespace System\Database;

use System\Database\Adapter\DBAdapter;
use System\Database\Adapter\DBAdapterInterface;
use System\Database\Adapter\MSSQLAdapter;
use System\Database\Adapter\MySQLAdapter;
use System\Database\Adapter\OracleAdapter;
use System\Database\Adapter\PgSQLAdapter;
use System\Database\Connector\MSSQL;
use System\Database\Connector\MySQL;
use System\Database\Connector\Oracle;
use System\Database\Connector\PgSQL;
use System\EventListener\EventTypes;
use System\Registry;

class DB
{
	const MYSQL = 'MySQL';

	const PGSQL = 'PgSQL';

	const ORACLE = 'Oracle';

	const MSSQL = 'MSSQL';

	const READ = 'read';

	const WRITE = 'write';

	/**
	 * @var Oracle
	 */
	private static $oracle;

	/**
	 * @var MSSQL
	 */
	private static $mssql;

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
	 */
	public static function PgSQLAdapter(): DBAdapterInterface
	{
		if (!isset(self::$adapters[self::PGSQL])) {
			self::$adapters[self::PGSQL] = new DBAdapter(new PgSQLAdapter(new PgSQL()));
		}

		return self::$adapters[self::MYSQL];
	}

	public static function OracleAdapter(): OracleAdapter
	{
		if (!self::$oracle instanceof OracleAdapter) {
			self::$oracle = new OracleAdapter(new Oracle());
		}

		return self::$oracle;
	}

	public static function MSSQLAdapter(): MSSQLAdapter
	{
		if (!self::$mssql instanceof MSSQL) {
			self::$mssql = new MSSQLAdapter(new MSSQL());
		}

		return self::$mssql;
	}
}