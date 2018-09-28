<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 23.04.2018
 * Time: 19:48
 */

namespace UserManager;

class UserRepository
{
	/**
	 * @var array
	 */
	private $userList = [];

	/**
	 * @var UserStorage
	 */
	private $storage;

	/**
	 * @param int $userId
	 * @return UserModel
	 */
	public function getById(int $userId): UserModel
	{
		return new UserModel();
	}

	/**
	 * @param array $userIds
	 * @return UserList
	 */
	public function getByIds(array $userIds): UserList
	{
		$this->userList =  new UserList();
		return $this->userList;
	}

	/**
	 * @param int $externalId
	 * @return UserModel
	 */
	public function getByExternalId(int $externalId): UserModel
	{
		return new UserModel();
	}

	private function getStorage(): UserStorage
	{
		if (!$this->storage instanceof UserStorage) {
			$this->storage = new UserStorage();
		}

		return $this->storage;
	}
}