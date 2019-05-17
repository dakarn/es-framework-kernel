<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 30.09.2018
 * Time: 0:35
 */

namespace System\Database\Connector;

use System\Database\DB;
use System\Database\DbConfigLogic\DbConfig;

class PgSQL implements DBConnectorInterface
{
	private $writer;

	private $readers;

	public function __construct()
	{
		$conf = DbConfig::create()->getConfigure(DB::MYSQL);

		$this->writer = $conf['write'];

		\pg_connect('host= port= dbname= user= password= options=\'--client_encoding=UTF8\'');

		foreach ($conf['read'] as $index => $reader) {
			$this->readers[$index] = \pg_connect('host= port= dbname= user= password= options=\'--client_encoding=UTF8\'');
		}
	}

	public function getWriter()
	{
		return $this->writer;
	}

	/**
	 * @param int $num
	 * @return mixed
	 * @throws \Exception
	 */
	public function getReader(int $num = 0)
	{
		if (empty($num)) {
			$num = \random_int(0, \count($this->readers) - 1);
		}

		return $this->readers[$num];
	}
}