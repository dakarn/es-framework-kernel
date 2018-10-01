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
	/**
	 * @var \mysqli
	 */
	private $connector;

	/**
	 * MySQLAdapter constructor.
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

	public function insert(string $sql)
	{
		$this->connector->query($sql);
	}

	public function update(string $sql)
	{
		$this->connector->query($sql);
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