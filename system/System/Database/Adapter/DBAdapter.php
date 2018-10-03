<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 02.10.2018
 * Time: 15:23
 */

namespace System\Database\Adapter;

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

	public function getAffected()
	{

	}

	public function getLastInsertId()
	{
		return $this->adaptee->getLastInsertId();
	}

	public function insert(string $sql)
	{
		return $this->adaptee->insert($sql);
	}

	/**
	 * @param string $sql
	 * @return mixed
	 */
	public function update(string $sql)
	{
		return $this->adaptee->update($sql);
	}

	public function delete(string $sql)
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