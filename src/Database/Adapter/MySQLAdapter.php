<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 30.09.2018
 * Time: 0:50
 */

namespace ES\Kernel\Database\Adapter;

use ES\Kernel\Database\Connector\DBConnectorInterface;
use ES\Kernel\Database\DB;

class MySQLAdapter implements AdapteeInterface
{
    /**
     * @var \mysqli
     */
    private $slave;

    /**
     * @var \mysqli
     */
    private $master;

	/**
	 * @var int
	 */
	private $affected = 0;

	/**
	 * @var \mysqli_stmt
	 */
	private $prepareStmt;

	/**
	 * @var \mysqli_result|bool
	 */
	private $result;

	/**
	 * MySQLAdapter constructor.
	 * @param DBConnectorInterface $connector
	 * @throws \Exception
	 */
	public function __construct(DBConnectorInterface $connector)
	{
		$this->master = $connector->getMaster();
		$this->slave  = $connector->getSlave();
	}

    /**
     * @return \mysqli
     */
	public function getWriterConnector(): \mysqli
    {
        return $this->master;
    }

    /**
     * @return \mysqli
     */
    public function getReaderConnector(): \mysqli
    {
        return $this->slave;
    }

	/**
	 * @param string $types
	 * @param array $values
	 * @return AdapteeInterface
	 */
	public function bindParams(string $types, array $values): AdapteeInterface
	{

		$params[] = $types;

		foreach ($values as $value) {
			$params[] = &$value;
		}

		\call_user_func_array([$this->prepareStmt, 'bind_param'], $params);

		return $this;
	}

	/**
	 * @param string $prepareSql
	 * @param string $sqlType
	 * @return AdapteeInterface
	 */
	public function prepare(string $prepareSql, string $sqlType): AdapteeInterface
	{
		switch (true) {
			case $sqlType === DB::READ:
				$this->prepareStmt = $this->slave->prepare($prepareSql);
				break;
			case $sqlType === DB::WRITE:
				$this->prepareStmt = $this->master->prepare($prepareSql);
				break;
		}

		return $this;
	}

	/**
	 * @return bool
	 */
	public function execute(): bool
	{
		$result       = $this->prepareStmt->execute();
		$this->result = $this->prepareStmt->get_result();

		return $result;

	}

	/**
	 * @return mixed|string
	 */
	public function getError()
	{
		return $this->slave->error ?? $this->master->error;
	}

	/**
	 * @return bool
	 */
	public function hasError(): bool
	{
		switch (true) {
			case $this->slave->error !== null:
				return true;
				break;
			case $this->master->error !== null:
				return true;
				break;
		}

		return false;
	}

	/**
	 * @param string $sql
	 * @return array
	 */
	public function fetchRow(string $sql): array
	{
		$query = $this->result = $this->slave->query($sql);

		return $query->fetch_assoc() ?? [];
	}

	/**
	 * @param string $sql
	 * @return array
	 */
	public function fetch(string $sql): array
	{
		$query = $this->result = $this->slave->query($sql);
		$data  = [];

		while ($row = $query->fetch_assoc()) {
			$data[] = $row;
		}

		return $data;
	}

	/**
	 * @return mixed
	 */
	public function getResult()
	{
		if ($this->prepareStmt === null) {
			return false;
		}

		if (!$this->result instanceof \mysqli_result) {
			return $this->result;
		}

		$ret = [];

		while ($row = $this->result->fetch_assoc()) {
			$ret[] = $row;
		}

		return $ret;
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
		return $this->master->insert_id;
	}

	/**
	 * @param string $sql
	 * @return bool
	 */
	public function insert(string $sql): bool
	{
		return $this->master->query($sql);
	}

	/**
	 * @param string $sql
	 * @return int
	 */
	public function update(string $sql): bool
	{
		$this->master->query($sql);

		return $this->master->affected_rows;
	}

	/**
	 * @param string $sql
	 * @return bool
	 */
	public function delete(string $sql): bool
	{
		return $this->master->query($sql);
	}

	/**
	 * @return bool
	 */
	public function close(): bool
	{
		return $this->master->close() && $this->slave->close();
	}

    /**
     * @param $text
     * @param bool $isReader
     * @return string
     */
	public function escapeString($text, bool $isReader)
    {
        return $isReader ? $this->slave->escape_string($text) : $this->master->escape_string($text);
    }

	/**
	 * @return mixed|void
	 */
	public function startTransaction()
	{
		$this->master->begin_transaction();
	}

	/**
	 * @return mixed|void
	 */
	public function commitTransaction()
	{
		$this->master->commit();
	}

	/**
	 * @return mixed|void
	 */
	public function rollbackTransaction()
	{
		$this->master->rollback();
	}
}