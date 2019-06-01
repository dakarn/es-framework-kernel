<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 02.10.2018
 * Time: 15:23
 */

namespace ES\Kernel\System\Database\Adapter;

use ES\Kernel\Helper\AbstractList;
use ES\Kernel\ObjectMapper\ObjectMapper;

class DBAdapter implements DBAdapterInterface
{
	/**
	 * @var AdapteeInterface
	 */
	private $adaptee;

	/**
	 * DBAdapter constructor.
	 * @param AdapteeInterface $adaptee
	 */
	public function __construct(AdapteeInterface $adaptee)
	{
		$this->adaptee = $adaptee;
	}

	/**
	 * @param string $prepareSql
	 * @param string $sqlType
	 * @return $this|mixed
	 */
	public function prepare(string $prepareSql, string $sqlType): DBAdapterInterface
	{
		$this->adaptee->prepare($prepareSql, $sqlType);

		return $this;
	}

	/**
	 * @return bool
	 */
	public function execute(): bool
	{
		return $this->adaptee->execute();
	}

	/**
	 * @param string $sql
	 * @return array
	 */
	public function fetch(string $sql): array
	{
		return $this->adaptee->fetch($sql);
	}

	/**
	 * @param string $sql
	 * @return array
	 */
	public function fetchRow(string $sql): array
	{
		return $this->adaptee->fetchRow($sql);
	}

	/**
	 * @param string $sql
	 * @param string $abstractList
	 * @param string $object
	 * @return AbstractList
	 * @throws \ES\Kernel\Exception\ObjectException
	 */
	public function fetchToObjectList(string $sql, string $abstractList, string $object = null): AbstractList
	{
		return ObjectMapper::create()->arraysToObjectList($this->adaptee->fetch($sql), $abstractList, $object);
	}

	/**
	 * @param string $sql
	 * @param string $object
	 * @return mixed
	 * @throws \ES\Kernel\Exception\ObjectException
	 */
	public function fetchRowToObject(string $sql, string $object)
	{
		return ObjectMapper::create()->arrayToObject($this->adaptee->fetchRow($sql), $object);
	}

	/**
	 * @return int
	 */
	public function getAffected(): int
	{
		return $this->adaptee->getAffected();
	}

	/**
	 * @return mixed
	 */
	public function getLastInsertId()
	{
		return $this->adaptee->getLastInsertId();
	}

	/**
	 * @param string $sql
	 * @return bool
	 */
	public function insert(string $sql): bool
	{
		return $this->adaptee->insert($sql);
	}

	/**
	 * @param string $sql
	 * @return mixed
	 */
	public function update(string $sql): bool
	{
		return $this->adaptee->update($sql);
	}

	/**
	 * @param string $sql
	 * @return bool
	 */
	public function delete(string $sql): bool
	{
		return $this->adaptee->delete($sql);
	}

	/**
	 * @param string $types
	 * @param array $values
	 * @return DBAdapter
	 */
	public function bindParams(string $types, array $values): DBAdapterInterface
	{
		$this->adaptee->bindParams($types, $values);

		return $this;
	}

	/**
	 * @return mixed
	 */
	public function getResult()
	{
		return $this->adaptee->getResult();
	}

	/**
	 * @return bool
	 */
	public function hasError(): bool
	{
		return false;
	}

	/**
	 * @return mixed|void
	 */
	public function startTransaction()
	{
		$this->adaptee->startTransaction();
	}

	/**
	 * @return mixed|void
	 */
	public function commitTransaction()
	{
		$this->adaptee->commitTransaction();
	}

	/**
	 * @return mixed|void
	 */
	public function rollbackTransaction()
	{
		$this->adaptee->rollbackTransaction();
	}

	/**
	 * @return mixed|void
	 */
	public function getError()
	{
		$this->adaptee->getError();
	}
}