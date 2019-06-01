<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 31.05.2019
 * Time: 20:27
 */

namespace ES\Kernel\System\Database\Schema\MySQL;

use ES\Kernel\System\Database\Adapter\DBAdapter;
use ES\Kernel\System\Database\Adapter\MySQLAdapter;
use ES\Kernel\System\Database\Schema\InitAdaptersDatabases;
use ES\Kernel\System\Database\Connector\MySQL;

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