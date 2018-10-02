<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 01.10.2018
 * Time: 18:49
 */

namespace System\Database\Adapter;

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

	public function getAffected();

	public function getLastInsertId();

	public function insert();

	public function update();

	public function delete();

	public function startTransaction();

	public function commitTransaction();

	public function rollbackTransaction();
}