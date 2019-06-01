<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 31.05.2019
 * Time: 21:03
 */

namespace ES\Kernel\System\Database\Schema;

use ES\Kernel\Exception\FileException;
use ES\Kernel\System\Database\Adapter\AdapteeInterface;
use ES\Kernel\System\Database\Adapter\DBAdapter;
use ES\Kernel\System\Database\DB;

abstract class InitAdaptersDatabases
{
	/**
	 * @var AdapteeInterface[]
	 */
	private $adapters = [];

	/**
	 * @param string $adapter
	 * @param string $dbType
	 * @param string $database
	 * @return mixed
	 * @throws FileException
	 */
	protected function initAdapter(string $adapter, string $dbType, string $database)
	{
		if (!self::isSetAdapter($dbType . $database)) {
			DB::initDbConfig(\basename($dbType), $database);
			$this->adapters[$dbType. $database] = new DBAdapter(new $adapter(new $dbType($database)));
		}

		return $this->adapters[$dbType . $database];
	}

	/**
	 * @param string $key
	 * @return bool
	 */
	private function isSetAdapter(string $key): bool
	{
		return isset($this->adapters[$key]);
	}

}