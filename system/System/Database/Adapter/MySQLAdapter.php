<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 30.09.2018
 * Time: 0:50
 */

namespace System\Database\Adapter;

use Helper\AbstractList;
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
	 * @param string $sql
	 * @param string $abstractList
	 * @param string $object
	 * @return AbstractList|null
	 */
	public function fetchToObjectList(string $sql, string $abstractList, string $object):? AbstractList
	{
		$rows = $this->fetch($sql);
		/** @var AbstractList $list */

		if (!\class_exists($abstractList)) {
			return null;
		}

		if (!\class_exists($object)) {
			return null;
		}

		$list = new $abstractList();

		foreach ($rows as $index => $row) {
			$list->add($index, new $object($row));
		}

		return $list;
	}

	/**
	 * @param string $sql
	 * @param string $object
	 * @return mixed
	 */
	public function fetchRowToObject(string $sql, string $object)
	{
		$result = $this->fetchRow($sql);

		if (!\class_exists($object)) {
			return null;
		}

		return new $object($result);
	}

	/**
	 * @return int
	 */
	public function getAffected(): int
	{
		return $this->affected;
	}

	/**
	 * @return mixed
	 */
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
	public function update(string $sql): bool
	{
		$this->writer->query($sql);

		return $this->writer->affected_rows;
	}

	/**
	 * @param string $sql
	 * @return bool
	 */
	public function delete(string $sql): bool
	{
		return $this->writer->query($sql);
	}

	/**
	 * @return bool
	 */
	public function close(): bool
	{
		return $this->writer->close() && $this->reader->close();
	}

	/**
	 * @return mixed|void
	 */
	public function startTransaction()
	{
		$this->writer->begin_transaction();
	}

	/**
	 * @return mixed|void
	 */
	public function commitTransaction()
	{
		$this->writer->commit();
	}

	/**
	 * @return mixed|void
	 */
	public function rollbackTransaction()
	{
		$this->writer->rollback();
	}
}