<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 02.10.2018
 * Time: 15:23
 */

namespace System\Database\Adapter;

class DBAdapter implements DBAdapterInterface
{
	/**
	 * @param string $sql
	 * @return array
	 */
	public function fetch(string $sql): array
	{
		return [];
	}

	/**
	 * @param string $sql
	 * @return array
	 */
	public function fetchRow(string $sql): array
	{
		return [];
	}

	public function getAffected()
	{

	}

	public function getLastInsertId()
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

	public function startTransaction()
	{

	}

	public function commitTransaction()
	{

	}

	public function rollbackTransaction()
	{

	}
}