<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 31.05.2019
 * Time: 20:27
 */

namespace ES\Kernel\Database\Schema\MySQL;

use ES\Kernel\Database\Adapter\DBAdapter;
use ES\Kernel\Database\Adapter\MySQLAdapter;
use ES\Kernel\Database\Schema\InitAdaptersDatabases;
use ES\Kernel\Database\Connector\MySQL;

class MySQLDatabases extends InitAdaptersDatabases
{
	public const TEACHER      = 'teacher';
	public const ES_FRAMEWORK = 'es-framework';

	/**
	 * @throws \Exception
	 */
	public function getTeacher(): DBAdapter
	{
		return $this->initAdapter(MySQLAdapter::class, MySQL::class, self::TEACHER);
	}

	/**
	 * @return DBAdapter
	 * @throws \ES\Kernel\Exception\FileException
	 */
	public function getESFramework(): DBAdapter
	{
		return $this->initAdapter(MySQLAdapter::class, MySQL::class, self::ES_FRAMEWORK);
	}
}