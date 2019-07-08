<?php

namespace ES\Kernel\Database;

use ES\Kernel\Database\QueryBuilder\QueryBuilderMySQL;
use ES\Kernel\Database\QueryBuilder\QueryBuilderPgSQL;
use ES\Kernel\Exception\FileException;
use ES\Kernel\Helper\StorageObjects;
use ES\Kernel\Database\Schema\MySQL\MySQLDatabases;
use ES\Kernel\Database\Schema\PgSQL\PostgresDatabases;
use ES\Kernel\Configs\Config;
use ES\Kernel\Database\DbConfigLogic\DbConfig;
use ES\Kernel\Database\DbConfigLogic\DatabaseConfigure;

class DB
{
	const MYSQL  = 'MySQL';
	const PGSQL  = 'PgSQL';
	const ORACLE = 'Oracle';
	const MSSQL  = 'MSSQL';

	const READ   = 'read';
	const WRITE  = 'write';

	/**
	 * @return MySQLDatabases
	 */
	public static function getMySQL(): MySQLDatabases
	{
		return StorageObjects::getMySQLDatabases();
	}

	/**
	 * @return PostgresDatabases
	 */
	public static function getPgSQL(): PostgresDatabases
	{
		return StorageObjects::getPostgresDatabases();
	}

    /**
     * @return QueryBuilderMySQL
     */
	public static function getQueryBuilderMySQL(): QueryBuilderMySQL
    {
        return StorageObjects::getQueryBuilderMySQL();
    }

    /**
     * @return QueryBuilderPgSQL
     */
    public static function getQueryBuilderPgSQL(): QueryBuilderPgSQL
    {
        return StorageObjects::getQueryBuilderPgSQL();
    }

	/**
	 * @param string $dbType
	 * @param string $database
	 * @throws FileException
	 */
	public static function initDbConfig(string $dbType, string $database)
	{
		$dbConfig = Config::get('db');
		DbConfig::create()->setConfigure($dbType, new DatabaseConfigure($dbConfig[$dbType][$database]));
	}
}