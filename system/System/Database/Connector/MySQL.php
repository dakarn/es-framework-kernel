<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 30.09.2018
 * Time: 0:35
 */

namespace System\Database\Connector;

class MySQL
{
	public function getConnector(): \mysqli
	{
		$connect = new \mysqli(
			self::$configure->getHost(),
			self::$configure->getUser(),
			self::$configure->getPassword(),
			self::$configure->getDatabase()
		);

		$connect->set_charset(self::$configure->getCharset());

		return $connect;
	}
}