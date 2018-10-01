<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 30.09.2018
 * Time: 0:50
 */

namespace System\Database\Adapter;


use System\Database\Connector\DBConnector;

class MySQLAdapter
{
	private $connector;

	public function __construct(DBConnector $connector)
	{
		$this->connector = $connector;
	}

	public function query()
	{

	}

	public function getAffected()
	{

	}

	public function insert()
	{

	}

	public function update()
	{

	}

	public function delete()
	{

	}
}