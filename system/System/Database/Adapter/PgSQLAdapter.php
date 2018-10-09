<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 30.09.2018
 * Time: 0:51
 */

namespace System\Database\Adapter;

use System\Database\Connector\DBConnectorInterface;

class PgSQLAdapter implements AdapteeInterface
{
	/**
	 * @var resource
	 */
	private $reader;

	/**
	 * @var resource
	 */
	private $writer;

	/**
	 * @var int
	 */
	private $affectedRows = 0;

	/**
	 * PgSQLAdapter constructor.
	 * @param DBConnectorInterface $connector
	 * @throws \Exception
	 */
	public function __construct(DBConnectorInterface $connector)
	{
		$this->writer = $connector->getWriter();
		$this->reader = $connector->getReader();
	}

	/**
	 * @param string $sql
	 * @return array
	 */
	public function fetch(string $sql): array
	{
		$query = \pg_query($this->reader, $sql);
		$data  = [];

		while ($row = \pg_fetch_assoc($query)) {
			$data[] = $row;
		}

		return $data;
	}

	/**
	 * @param string $sql
	 * @return array
	 */
	public function fetchRow(string $sql): array
	{
		$query = \pg_query($this->reader, $sql);

		return \pg_fetch_assoc($query);

	}

	/**
	 * @param string $sql
	 * @param string $abstractList
	 * @return mixed|void
	 */
	public function fetchToObjectList(string $sql,  string $abstractList)
	{

	}

	/**
	 * @param string $sql
	 * @param string $object
	 */
	public function fetchRowToObject(string $sql,  string $object)
	{

	}

	/**
	 * @return int
	 */
	public function getAffected(): int
	{
		return $this->affectedRows;
	}

	public function getLastInsertId()
	{
	}

	/**
	 * @param string $sql
	 * @return bool
	 */
	public function insert(string $sql): bool
	{
		$result = \pg_affected_rows(\pg_query($sql));
		$this->affectedRows = $result;

		return $result === 0 ? false : true;
	}

	/**
	 * @param string $sql
	 * @return bool
	 */
	public function update(string $sql): bool
	{
		$result = \pg_affected_rows(\pg_query($sql));
		$this->affectedRows = $result;

		return $result === 0 ? false : true;
	}

	/**
	 * @param string $sql
	 * @return bool
	 */
	public function delete(string $sql): bool
	{
		$result = pg_affected_rows(\pg_query($sql));
		$this->affectedRows = $result;

		return $result === 0 ? false : true;
	}

	/**
	 * @return bool
	 */
	public function close(): bool
	{
		return \pg_close($this->reader) && pg_close($this->writer);
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