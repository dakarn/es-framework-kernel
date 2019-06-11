<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 04.10.2018
 * Time: 20:34
 */

namespace ES\Kernel\Models\User;

use ES\Kernel\Helper\Util;
use ES\Kernel\Database\DB;

class UserStrategy
{
	/**
	 * @var bool
	 */
	private $isWrite = false;

	/**
	 * @var bool
	 */
	private $isUpdate = false;

	/**
	 * @var bool
	 */
	private $isDelete = false;

	/**
	 * @var bool
	 */
	private $isLoadedUser = false;

	/**
	 * @var bool
	 */
	private $isCorrectPassword = false;

	/**
	 * @param array $props
	 * @return bool
	 * @throws \Exception
	 */
	public function createUser(array $props): bool
	{
		$this->isWrite = DB::getMySQL()->getESFramework()->insert('
			INSERT INTO `user`
			(
				password, 
				email, 
				login, 
				role, 
				created
			)
			VALUES (
				"' . $props['password'] . '",
			    "' . $props['email'] . '", 
			    "' . $props['login'] . '", 
			    ' . User::ROLE_USER . ', 
			    "' . Util::toDbTime() . '")
		');

		return $this->isWrite;
	}

	/**
	 * @return bool
	 */
	public function deleteUser(): bool
	{
		$this->isDelete = true;
		return true;
	}

	/**
	 * @return bool
	 */
	public function updateUser(): bool
	{
		$this->isUpdate = true;
		return true;
	}

	/**
	 * @param string $email
	 * @return array
	 * @throws \Exception
	 */
	public function loadByEmail(string $email): array
	{
		$this->isLoadedUser = DB::getMySQL()->getESFramework()->fetchRow('
			SELECT 
				userId,
				email,
				login,
				password,
				role,
				created 
			FROM user
			WHERE 
				`email` = "' . $email . '"
			LIMIT 1
		');

		return $this->isLoadedUser;
	}

	/**
	 * @param string $login
	 * @return array
	 * @throws \Exception
	 */
	public function loadByLogin(string $login): array
	{
		$this->isLoadedUser = DB::getMySQL()->getESFramework()->fetchRow('
			SELECT 
				userId,
				email,
				login,
				password,
				role,
				created 
			FROM user
			WHERE 
				`login` = "' . $login . '" 
			LIMIT 1
		');

		return $this->isLoadedUser;
	}

	/**
	 * @param int $userId
	 * @return array
	 * @throws \Exception
	 */
	public function loadByUserId(int $userId): array
	{
		$this->isLoadedUser = DB::getMySQL()->getESFramework()->fetchRow('
			SELECT 
				userId,
				email,
				login,
				password,
				role,
				created 
			FROM user
			WHERE 
				`userId` = ' . $userId . '
			LIMIT 1
		');

		return $this->isLoadedUser;
	}

	/**
	 * @param string $email
	 * @param string $login
	 * @return array
	 * @throws \Exception
	 */
	public function loadByEmailOrLogin(string $email, string $login): array
	{
		/*$this->isLoadedUser = DB::MySQLAdapter()->fetchRow('
			SELECT 
				userId,
				email,
				login,
				password,
				role,
				created 
			FROM user
			WHERE 
				`login` = "' . $login . '" 
				OR `email` = "' . $email . '"
			LIMIT 1
		');*/

		$this->isLoadedUser = [
			'userId' => 11,
			'login' => 'Dakarn',
			'password' => '$2y$10$616de4W2jYskfAAr9PxXAOcUvHlFGeta/tYgc0HEz4EXsxVXi0Vw.',
			'email' => 'dakarn9@mail.ru',
			'role' => 1,
			'created' => '0001-01-01 00:00:00'
		];

		return $this->isLoadedUser;
	}

	/**
	 * @return bool
	 */
	private function verifyPassword(): bool
	{
		$this->isCorrectPassword = true;

		return true;
	}
}