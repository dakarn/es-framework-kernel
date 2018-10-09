<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 02.10.2018
 * Time: 15:23
 */

namespace System\Database\Adapter;

use Helper\AbstractList;

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
	 */
	public function fetchToObjectList(string $sql, string $abstractList, string $object): AbstractList
	{
		return $this->adaptee->fetchToObjectList($sql, $abstractList, $object);
	}

	/**
	 * @param string $sql
	 * @param string $object
	 */
	public function fetchRowToObject(string $sql, string $object)
	{
		return $this->adaptee->fetchRowToObject($sql, $object);
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

	public function startTransaction()
	{
		$this->adaptee->startTransaction();
	}

	public function commitTransaction()
	{
		$this->adaptee->commitTransaction();
	}

	public function rollbackTransaction()
	{
		$this->adaptee->rollbackTransaction();
	}
}