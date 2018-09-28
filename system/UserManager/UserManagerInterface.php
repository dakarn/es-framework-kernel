<?php
/**
 * Created by PhpStorm.
 * User: v.konovalov
 * Date: 23.04.2018
 * Time: 15:47
 */

namespace UserManager;

interface UserManagerInterface
{
	/**
	 * @param int $userId
	 * @return UserModel
	 */
	public function getById(int $userId): UserModel;

	/**
	 * @param int $externalId
	 * @return UserModel
	 */
	public function getByExternalId(int $externalId): UserModel;
}