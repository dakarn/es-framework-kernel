<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 30.09.2018
 * Time: 0:35
 */

namespace ES\Kernel\Database\Connector;

use ES\Kernel\Database\DB;
use ES\Kernel\Database\DbConfigLogic\DbConfig;

class PgSQL extends AbstractDBConnector implements DBConnectorInterface
{
    /**
     * @var array
     */
	private $readers;

	public function initSlave(int $num)
	{

	}

	public function initMaster()
	{

	}

	/**
     * PgSQL constructor.
     * @param string $database
     */
	public function __construct(string $database)
	{
		$this->database = $database;
		$conf = DbConfig::create()->getConfigure(DB::PGSQL)[$this->database];

		$this->setMaster($conf['write']);

		\pg_connect('host= port= dbname= user= password= options=\'--client_encoding=UTF8\'');

		foreach ($conf['read'] as $index => $reader) {
			$this->readers[$index] = \pg_connect('host= port= dbname= user= password= options=\'--client_encoding=UTF8\'');
		}
	}

	/**
	 * @param int $num
	 * @return mixed
	 * @throws \Exception
	 */
	public function getSlave(int $num = 0)
	{
		if (empty($num)) {
			$num = \random_int(0, \count($this->readers) - 1);
		}

		return $this->readers[$num];
	}
}