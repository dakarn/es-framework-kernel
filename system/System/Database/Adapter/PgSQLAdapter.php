<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 30.09.2018
 * Time: 0:51
 */

namespace System\Database\Adapter;

use System\Database\Connector\DBConnector;

class PgSQLAdapter
{
	/**
	 * @var resource
	 */
	private $connector;

	/**
	 * PgSQLAdapter constructor.
	 * @param DBConnector $connector
	 */
	public function __construct(DBConnector $connector)
	{
		$this->connector = $connector->getConnector();
	}

	/**
	 * @param string $sql
	 * @return array
	 */
	public function query(string $sql): array
	{
		$query = \pg_query($this->connector, $sql);
		$data  = [];

		while ($row = \pg_fetch_assoc($query)) {
			$data[] = $row;
		}

		return $data;
	}

	public function getAffected()
	{

	}

	public function getLastInsertId()
	{
	}

	public function insert(string $sql)
	{

	}

	public function update(string $sql)
	{

	}

	public function delete(string $sql)
	{

	}

	/**
	 * @return bool
	 */
	public function close(): bool
	{
		return \pg_close($this->connector);
	}

	public function startTransaction()
	{
		\pg_query('BEGIN');
	}

	public function commitTransaction()
	{
		\pg_query('COMMIT');
	}

	public function rollbackTransaction()
	{
		\pg_query('ROLLBACK');
	}
}