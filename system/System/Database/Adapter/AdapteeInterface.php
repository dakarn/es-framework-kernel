<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 02.10.2018
 * Time: 20:12
 */

namespace System\Database\Adapter;

interface AdapteeInterface
{
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

	public function getAffected();

	public function getLastInsertId();

	/**
	 * @param string $sql
	 * @return mixed
	 */
	public function insert(string $sql);

	public function update(string $sql);

	public function delete(string $sql);

	/**
	 * @return bool
	 */
	public function close(): bool;

	public function startTransaction();

	public function commitTransaction();

	public function rollbackTransaction();
}