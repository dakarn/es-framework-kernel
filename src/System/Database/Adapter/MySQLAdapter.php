<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 30.09.2018
 * Time: 0:50
 */

namespace ES\Kernel\System\Database\Adapter;

use ES\Kernel\Helper\AbstractList;
use ES\Kernel\ObjectMapper\ClassToMappingInterface;
use ES\Kernel\ObjectMapper\ObjectMapper;
use ES\Kernel\System\Database\Connector\DBConnectorInterface;
use ES\Kernel\System\Database\DB;

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
		$this->writer = $connector->getWriter();
		$this->reader = $connector->getReader();
	}

    /**
     * @return \mysqli
     */
	public function getWriterConnector(): \mysqli
    {
        return $this->writer;
    }

    /**
     * @return \mysqli
     */
    public function getReaderConnector(): \mysqli
    {
        return $this->reader;
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
				$this->prepareStmt = $this->reader->prepare($prepareSql);
				break;
			case $sqlType === DB::WRITE:
				$this->prepareStmt = $this->writer->prepare($prepareSql);
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
		return $this->reader->error ?? $this->writer->error;
	}

	/**
	 * @return bool
	 */
	public function hasError(): bool
	{
		switch (true) {
			case $this->reader->error !== null:
				return true;
				break;
			case $this->writer->error !== null:
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
		$query = $this->result = $this->reader->query($sql);

		return $query->fetch_assoc() ?? [];
	}

	/**
	 * @param string $sql
	 * @return array
	 */
	public function fetch(string $sql): array
	{
		$query = $this->result = $this->reader->query($sql);
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