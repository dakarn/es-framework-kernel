<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 30.09.2018
 * Time: 0:51
 */

namespace ES\Kernel\Database\Adapter;

use ES\Kernel\Database\Connector\DBConnectorInterface;

class PgSQLAdapter implements AdapteeInterface
{
	/**
	 * @var resource
	 */
	private $slave;

	/**
	 * @var resource
	 */
	private $master;

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
		$this->master = $connector->getMaster();
		$this->slave  = $connector->getSlave();
	}

    /**
     * @return mixed
     */
    public function getWriterConnector()
    {
        return $this->master;
    }

    /**
     * @return mixed
     */
    public function getReaderConnector()
    {
        return $this->slave;
    }

	/**
	 * @return bool
	 */
	public function execute(): bool
	{
		return true;
	}

	/**
	 * @param string $prepareSql
	 * @param string $sqlType
	 * @return AdapteeInterface
	 */
	public function prepare(string $prepareSql, string $sqlType): AdapteeInterface
	{
		return $this;
	}

	/**
	 * @return mixed|void
	 */
	public function getResult()
	{

	}

    /**
     * @param $text
     * @param bool $isReader
     * @return mixed|string
     */
    public function escapeString($text, bool $isReader)
    {
        return $isReader ? pg_escape_string($this->slave, $text) : pg_escape_string($this->master, $text);
    }

	/**
	 * @param string $sql
	 * @return array
	 */
	public function fetch(string $sql): array
	{
		$query = \pg_query($this->slave, $sql);
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
		$query = \pg_query($this->slave, $sql);

		return \pg_fetch_assoc($query);

	}

	/**
	 * @return int
	 */
	public function getAffected(): int
	{
		return $this->affectedRows;
	}

	/**
	 * @return mixed|void
	 */
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
	 * @param string $types
	 * @param array $values
	 * @return AdapteeInterface
	 */
	public function bindParams(string $types, array $values): AdapteeInterface
	{
		return $this;
	}

	/**
	 * @return mixed|void
	 */
	public function getError()
	{

	}

	/**
	 * @return bool
	 */
	public function hasError(): bool
	{
		return false;
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
		$result = \pg_affected_rows(\pg_query($sql));
		$this->affectedRows = $result;

		return $result === 0 ? false : true;
	}

	/**
	 * @return bool
	 */
	public function close(): bool
	{
		return \pg_close($this->slave) && \pg_close($this->master);
	}

	/**
	 * @return mixed|void
	 */
	public function startTransaction()
	{
		\pg_query('BEGIN');
	}

	/**
	 * @return mixed|void
	 */
	public function commitTransaction()
	{
		\pg_query('COMMIT');
	}

	/**
	 * @return mixed|void
	 */
	public function rollbackTransaction()
	{
		\pg_query('ROLLBACK');
	}
}