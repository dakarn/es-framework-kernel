<?php

namespace ES\Kernel\UserManager;

use ES\Kernel\Database\DB;
use ES\Kernel\Exception\FileException;
use ES\Kernel\Exception\ObjectException;
use ES\Kernel\Helper\RepositoryHelper\AbstractRepository;
use ES\Kernel\Helper\RepositoryHelper\RepositoryInterface;
use ES\Kernel\Helper\Util;
use ES\Kernel\ObjectMapper\ObjectMapper;

class UserRepository extends AbstractRepository implements RepositoryInterface
{
    protected function getStorageClassName(): string
    {
        return UserStorage::class;
    }

    /**
     * @param User $user
     * @return bool
     * @throws FileException
     */
    public function createUser(User $user): User
    {
        $this->isSaved = DB::getMySQL()->getESFramework()->insert('
			INSERT INTO `user` (
				password, 
				email, 
				login, 
				role, 
				created
			)
			VALUES (
				"' . $user->getPassword() . '",
			    "' . $user->getEmail() . '", 
			    "' . $user->getLogin() . '", 
			    ' . User::ROLE_USER . ', 
			    "' . Util::toDbTime() . '"
            )
		');

        return $user->setUserId(DB::getMySQL()->getESFramework()->getLastInsertId());
    }

    /**
     * @return bool
     */
    public function deleteUser(): bool
    {
        $this->isSaved = true;

        return true;
    }

    /**
     * @return bool
     */
    public function updateUser(): bool
    {
        $this->isSaved = true;

        return true;
    }

    /**
     * @param string $email
     * @return User|null
     * @throws FileException
     * @throws ObjectException
     */
    public function loadByEmail(string $email): ?User
    {
        $result = DB::getMySQL()->getESFramework()->fetchRow('
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

        if (!empty($result)) {
            $this->isLoaded = true;
            return null;
        }

        return ObjectMapper::create()->arrayToObject($result, User::class);
    }

    /**
     * @param string $login
     * @return User|null
     * @throws FileException
     * @throws ObjectException
     */
    public function loadByLogin(string $login): ?User
    {
        $result = DB::getMySQL()->getESFramework()->fetchRow('
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

        if (!empty($result)) {
            $this->isLoaded = true;
            return null;
        }

        return ObjectMapper::create()->arrayToObject($result, User::class);
    }

    /**
     * @param int $userId
     * @return User|null
     * @throws FileException
     * @throws ObjectException
     */
    public function loadByUserId(int $userId): ?User
    {
        $result = DB::getMySQL()->getESFramework()->fetchRow('
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

        if (!empty($result)) {
            $this->isLoaded = true;
            return null;
        }

        return ObjectMapper::create()->arrayToObject($result, User::class);
    }

    /**
     * @param User $user
     * @return User|null
     * @throws FileException
     * @throws ObjectException
     */
    public function loadByEmailOrLogin(User $user): ?User
    {
        $result = DB::getMySQL()->getESFramework()->fetchRow('
            SELECT
                userId,
                email,
                login,
                password,
                role,
                created
            FROM user
            WHERE
                `login` = "' . $user->getLogin() . '"
                OR `email` = "' . $user->getEmail() . '"
            LIMIT 1
        ');

        if (!empty($result)) {
            $this->isLoaded = true;
            return null;
        }

        return ObjectMapper::create()->arrayToObject($result, User::class);
    }
}