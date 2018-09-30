<?php

namespace System\Database;

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

    /**
     * @param DatabaseConfigure $configure
     */
	public static function setConfigure(DatabaseConfigure $configure)
	{
		self::$configure = $configure;
	}

	public static function createMySQL()
	{
	    self::$mysql = (new MySQL())->getConnector();
	}

	public static function createPgSQL()
	{
	    self::$pgsql = (new PgSQL())->getConnector();
	}

	public static function createOracle()
	{
	    self::$oracle = new Oracle();
	}

	public static function createMSSQL()
	{
	    self::$mssql = new MSSQL();
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