<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 31.05.2019
 * Time: 20:27
 */

namespace ES\Kernel\System\Database\Schema\MySQL;

use ES\Kernel\System\Database\Adapter\MySQLAdapter;
use ES\Kernel\System\Database\DB;
use ES\Kernel\System\Database\Schema\InitAdaptersDatabases;

class MySQLDatabases extends InitAdaptersDatabases
{
	private const TEACHER      = 'teacher';
	private const ES_FRAMEWORK = 'es-framework';

	/**
	 * @throws \Exception
	 */
	public function getTeacher(): MySQLAdapter
	{
		return $this->initAdapter(MySQLAdapter::class, DB::MYSQL, self::TEACHER);
	}

	/**
	 * @return MySQLAdapter
	 * @throws \ES\Kernel\Exception\FileException
	 */
	public function getESFramework(): MySQLAdapter
	{
		return $this->initAdapter(MySQLAdapter::class, DB::MYSQL, self::ES_FRAMEWORK);
	}
}