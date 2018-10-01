<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 30.09.2018
 * Time: 0:35
 */

namespace System\Database\Connector;

use System\Database\DB;
use System\Database\DbConfig;

class MySQL implements DBConnectorInterface
{
	public function getConnector()
	{
		$conf = DbConfig::create()->getConfigure(DB::MYSQL)['read'];

		$connect = new \mysqli(
			$conf->getHost(),
			$conf->getUser(),
			$conf->getPassword(),
			$conf->getDatabase()
		);

		$connect->set_charset($conf->getCharset());

		return $connect;
	}
}