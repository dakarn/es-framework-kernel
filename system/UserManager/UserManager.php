<?php
/**
 * Created by PhpStorm.
 * User: v.konovalov
 * Date: 23.04.2018
 * Time: 15:45
 */

namespace UserManager;

class UserManager implements UserManagerInterface
{
	/**
	 * @var UserRepository
	 */
	private $repository;

	/**
	 * @param int $externalId
	 * @return UserModel
	 */
	public function getByExternalId(int $externalId): UserModel
	{
		return $this->getRepo()->getByExternalId($externalId);
	}

	/**
	 * @param int $userId
	 * @return UserModel
	 */
	public function getById(int $userId): UserModel
	{
		return $this->getRepo()->getById($userId);
	}

	/**
	 * @return UserModel
	 */
	public function current(): UserModel
	{
		return new UserModel();
	}

	/**
	 * @param array $userIds
	 * @return UserList
	 */
	public function getByIds(array $userIds): UserList
	{
		return $this->getRepo()->getByIds($userIds);
	}

	/**
	 * @return UserRepository
	 */
	private function getRepo()
	{
		if (!$this->repository instanceof UserRepository) {
			$this->repository = new UserRepository();
		}

		return $this->repository;
	}
}