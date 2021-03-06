<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 01.10.2018
 * Time: 18:49
 */

namespace ES\Kernel\Database\Adapter;

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
	public function fetchToObjectList(string $sql, $abstractList, $object = null);

	/**
	 * @param string $sql
	 * @param string $object
	 * @return mixed
	 */
	public function fetchRowToObject(string $sql, $object);

    /**
     * @param $text
     * @param bool $isReader
     * @return mixed
     */
    public function escapeString($text, bool $isReader);

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
	 * @param string $prepareSql
	 * @param string $sqlType
	 * @return mixed
	 */
	public function prepare(string $prepareSql, string $sqlType): DBAdapterInterface;

	/**
	 * @return bool
	 */
	public function execute(): bool;

	/**
	 * @param string $sql
	 * @return bool
	 */
	public function update(string $sql): bool;

	/**
	 * @return mixed
	 */
	public function getResult();

	/**
	 * @param string $sql
	 * @return bool
	 */
	public function delete(string $sql): bool;

	/**
	 * @param string $types
	 * @param array $values
	 * @return DBAdapter
	 */
	public function bindParams(string $types, array $values): DBAdapterInterface;

	/**
	 * @return mixed
	 */
	public function getError();

	/**
	 * @return bool
	 */
	public function hasError(): bool;

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