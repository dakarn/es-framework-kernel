<?php

namespace System\Database;

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
     * @var \mysqli
     */
	private static $connect;

	/**
	 * @var DatabaseConfigure
	 */
	private static $configure;

	/**
	 * @var MySQL
	 */
	private static $mysql;

	/**
	 * @var PgSQL
	 */
	private static $pgsql;

	/**
	 * @var Oracle
	 */
	private static $oracle;

	/**
	 * @var MSSQL
	 */
	private static $mssql;

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

	public static function MySQLAdapter(): MySQLAdapter
	{
		if (!self::$mysql instanceof MySQLAdapter) {
			self::$mysql = new MySQLAdapter(new MySQL());
		}

	    return self::$mysql;
	}

	public static function PgSQLadapter(): PgSQLAdapter
	{
		if (!self::$pgsql instanceof PgSQLAdapter) {
			self::$pgsql = new PgSQLAdapter(new PgSQL());
		}

		return self::$pgsql;
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

	/**
	 * @return \mysqli
	 * @throws \Exception\KernelException
	 */
	public static function create(): \mysqli
	{
		if (!self::$connect instanceof \mysqli) {
            $event = Registry::get(Registry::APP_EVENT);
		    $event->runEvent(EventTypes::BEFORE_DB_CONNECT);

			self::$connect = new \mysqli(
				self::$configure->getHost(),
				self::$configure->getUser(),
				self::$configure->getPassword(),
				self::$configure->getDatabase()
			);

			self::$connect->set_charset(self::$configure->getCharset());
            $event->runEvent(EventTypes::AFTER_DB_CONNECT);
		}

		return self::$connect;
	}

	/**
	 * @return bool
	 */
	public static function disconnect(): bool
	{
		if (self::$connect instanceof \mysqli) {
			\mysqli_close(self::$connect);
			return true;
		}

		return false;
	}


}