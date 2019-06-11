<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 02.10.2018
 * Time: 20:12
 */

namespace ES\Kernel\Database\Adapter;

interface AdapteeInterface
{
	/**
	 * @param string $prepareSql
	 * @param string $sqlType
	 * @return AdapteeInterface
	 */
	public function prepare(string $prepareSql, string $sqlType): AdapteeInterface;

    /**
     * @return mixed
     */
    public function getWriterConnector();

    /**
     * @return mixed
     */
    public function getReaderConnector();

	/**
	 * @return bool
	 */
	public function execute(): bool;

	/**
	 * @return mixed
	 */
	public function getResult();

	/**
	 * @param string $sql
	 * @return array
	 */
	public function fetchRow(string $sql): array;

	/**
	 * @param string $sql
	 * @return array
	 */
	public function fetch(string $sql): array;

	/**
	 * @return int
	 */
	public function getAffected(): int;

	/**
	 * @return mixed
	 */
	public function getLastInsertId();

	/**
	 * @param string $sql
	 * @return mixed
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
	 * @return bool
	 */
	public function close(): bool;

	/**
	 * @param string $types
	 * @param array $values
	 * @return AdapteeInterface
	 */
	public function bindParams(string $types, array $values): AdapteeInterface;

	/**
	 * @return bool
	 */
	public function hasError(): bool;

	/**
	 * @return mixed
	 */
	public function getError();

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