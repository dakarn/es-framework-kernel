<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 30.09.2018
 * Time: 0:35
 */

namespace System\Database\Connector;

class PgSQL
{
	/**
	 * @return resource
	 */
	public function getConnector()
	{
		$connect = \pg_connect('host= port= dbname= user= password= options=\'--client_encoding=UTF8\'');

		return $connect;
	}
}