<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 30.09.2018
 * Time: 0:51
 */

namespace System\Database\Adapter;

use System\Database\Connector\DBConnectorInterface;

class PgSQLAdapter
{
	/**
	 * @var resource
	 */
	private $connector;

	/**
	 * PgSQLAdapter constructor.
	 * @param DBConnectorInterface $connector
	 */
	public function __construct(DBConnectorInterface $connector)
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
		\pg_query($sql);
	}

	public function update(string $sql)
	{
		\pg_query($sql);
	}

	public function delete(string $sql)
	{
		\pg_query($sql);
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