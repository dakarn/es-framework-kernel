<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 01.10.2018
 * Time: 18:49
 */

namespace System\Database\Adapter;

use System\Database\Connector\DBConnectorInterface;

interface DBAdapterInterface
{
	public function __construct(DBConnectorInterface $connector);

	/**
	 * @param string $sql
	 * @return array
	 */
	public function query(string $sql): array;

	public function getAffected();

	public function getLastInsertId();

	public function insert();

	public function update();

	public function delete();

	public function startTransaction();

	public function commitTransaction();

	public function rollbackTransaction();
}