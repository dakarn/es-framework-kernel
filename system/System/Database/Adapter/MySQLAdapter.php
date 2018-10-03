<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 30.09.2018
 * Time: 0:50
 */

namespace System\Database\Adapter;

use System\Database\Connector\DBConnectorInterface;

class MySQLAdapter implements AdapteeInterface
{
	/**
	 * @var \mysqli
	 */
	private $connector;

	/**
	 * MySQLAdapter constructor.
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
	public function fetchRow(string $sql): array
	{
		$query = $this->connector->query($sql);

		return $query->fetch_assoc() ?? [];
	}

	/**
	 * @param string $sql
	 * @return array
	 */
	public function fetch(string $sql): array
	{
		$query = $this->connector->query($sql);
		$data  = [];

		while ($row = $query->fetch_assoc()) {
			$data[] = $row;
		}

		return $data;
	}

	public function getAffected()
	{

	}

	public function getLastInsertId()
	{
		return $this->connector->insert_id;
	}

	/**
	 * @param string $sql
	 * @return bool
	 */
	public function insert(string $sql): bool
	{
		return $this->connector->query($sql);
	}

	/**
	 * @param string $sql
	 * @return int
	 */
	public function update(string $sql): int
	{
		$this->connector->query($sql);

		return $this->connector->affected_rows;
	}

	public function delete(string $sql)
	{
		$this->connector->query($sql);
	}

	/**
	 * @return bool
	 */
	public function close(): bool
	{
		return $this->connector->close();
	}

	public function startTransaction()
	{
		$this->connector->begin_transaction();
	}

	public function commitTransaction()
	{
		$this->connector->commit();
	}

	public function rollbackTransaction()
	{
		$this->connector->rollback();
	}
}