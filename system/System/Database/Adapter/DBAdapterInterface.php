<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 01.10.2018
 * Time: 18:49
 */

namespace System\Database\Adapter;

use Helper\AbstractList;

interface DBAdapterInterface
{
	/**
	 * @param string $sql
	 * @return array
	 */
	public function fetch(string $sql): array;

	/**
	 * @param string $sql
	 * @return array
	 */
	public function fetchRow(string $sql): array;

	/**
	 * @return int
	 */
	public function getAffected(): int;

	/**
	 * @param string $sql
	 * @param string $abstractList
	 * @param string $object
	 * @return mixed
	 */
	public function fetchToObjectList(string $sql, string $abstractList, string $object);

	/**
	 * @param string $sql
	 * @param string $object
	 * @return mixed
	 */
	public function fetchRowToObject(string $sql, string $object);

	/**
	 * @return mixed
	 */
	public function getLastInsertId();

	/**
	 * @param string $sql
	 * @return bool
	 */
	public function insert(string $sql): bool;

	/**
	 * @param string $sql
	 * @return bool
	 */
	public function update(string $sql): bool;

	/**
	 * @param string $sql
	 * @return bool
	 */
	public function delete(string $sql): bool;

	/**
	 * @return mixed
	 */
	public function startTransaction();

	/**
	 * @return mixed
	 */
	public function commitTransaction();

	/**
	 * @return mixed
	 */
	public function rollbackTransaction();
}