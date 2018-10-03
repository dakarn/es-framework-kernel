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
	private $reader;

	/**
	 * @var \mysqli
	 */
	private $writer;

	/**
	 * @var int
	 */
	private $affected = 0;

	/**
	 * MySQLAdapter constructor.
	 * @param DBConnectorInterface $connector
	 * @throws \Exception
	 */
	public function __construct(DBConnectorInterface $connector)
	{
		$this->writer    = $connector->getWriter();
		$this->reader   = $connector->getReader();
	}

	/**
	 * @param string $sql
	 * @return array
	 */
	public function fetchRow(string $sql): array
	{
		$query = $this->reader->query($sql);

		return $query->fetch_assoc() ?? [];
	}

	/**
	 * @param string $sql
	 * @return array
	 */
	public function fetch(string $sql): array
	{
		$query = $this->reader->query($sql);
		$data  = [];

		while ($row = $query->fetch_assoc()) {
			$data[] = $row;
		}

		return $data;
	}

	/**
	 * @return int
	 */
	public function getAffected(): int
	{
		return $this->affected;
	}

	public function getLastInsertId()
	{
		return $this->writer->insert_id;
	}

	/**
	 * @param string $sql
	 * @return bool
	 */
	public function insert(string $sql): bool
	{
		return $this->writer->query($sql);
	}

	/**
	 * @param string $sql
	 * @return int
	 */
	public function update(string $sql): int
	{
		$this->writer->query($sql);

		return $this->writer->affected_rows;
	}

	public function delete(string $sql)
	{
		$this->writer->query($sql);
	}

	/**
	 * @return bool
	 */
	public function close(): bool
	{
		return $this->writer->close() && $this->reader->close();
	}

	public function startTransaction()
	{
		$this->writer->begin_transaction();
	}

	public function commitTransaction()
	{
		$this->writer->commit();
	}

	public function rollbackTransaction()
	{
		$this->writer->rollback();
	}
}