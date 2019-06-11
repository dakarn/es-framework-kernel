<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 25.03.2019
 * Time: 1:19
 */

namespace ES\Kernel\Models\User;

use ES\Kernel\Validators\AbstractValidator;

interface UserInterface
{
	/**
	 * @return User
	 * @throws \ES\Kernel\Exception\FileException
	 */
	public static function current(): User;

	/**
	 * @return User
	 */
	public static function create(): User;

	/**
	 * User constructor.
	 */
	public function __construct();

	/**
	 * @return UserStrategy
	 */
	public function getStrategyUser(): UserStrategy;

	/**
	 * @return array
	 */
	public function getErrors(): array;

	/**
	 * @param string $created
	 * @return User
	 */
	public function setCreated(string $created): User;

	/**
	 * @return string
	 */
	public function getCreated(): string;

	/**
	 * @return string
	 */
	public function getUserId(): string;

	/**
	 * @param string $login
	 * @return User
	 */
	public function setLogin(string $login): User;

	/**
	 * @return string
	 */
	public function getLogin(): string;

	/**
	 * @param string $email
	 * @return User
	 */
	public function setEmail(string $email): User;

	/**
	 * @return string
	 */
	public function getEmail(): string;

	/**
	 * @param string $role
	 * @return User
	 */
	public function setRole(string $role): User;

	/**
	 * @return string
	 */
	public function getRole(): string;

	/**
	 * @return string
	 */
	public function getPassword(): string;

	/**
	 * @param string $password
	 * @return User
	 * @throws \ES\Kernel\Exception\FileException
	 */
	public function setPassword(string $password): User;

	/**
	 * @throws \Exception
	 */
	public function authentication(): void;

	/**
	 * @return bool
	 * @throws \ES\Kernel\Exception\FileException
	 */
	public function logout(): bool;

	/**
	 * @return bool
	 * @throws \ES\Kernel\Exception\FileException
	 */
	public function logoutAllDevice(): bool;

	/**
	 * @param int $userId
	 * @return UserInterface|null
	 */
	public static function loadByUserId(int $userId): ?UserInterface;

	/**
	 * @param string $login
	 * @return UserInterface|null
	 */
	public static function loadByLogin(string $login): ?UserInterface;

	/**
	 * @param string $email
	 * @return User|void
	 */
	public static function loadByEmail(string $email): ?UserInterface;

	/**
	 * @param AbstractValidator $form
	 * @return UserInterface|null
	 * @throws \ES\Kernel\Exception\FileException
	 */
	public static function loadByEmailOrLogin(AbstractValidator $form): ?UserInterface;

	/**
	 * @return bool
	 */
	public function isLoaded(): bool;

	/**
	 * @return bool
	 * @throws \ES\Kernel\Exception\FileException
	 */
	public function isAuth(): bool;

	/**
	 * @return bool
	 */
	public function isSaved(): bool;

	/**
	 * @param int $role
	 * @return bool
	 */
	public function isGranted(int $role): bool;

	/**
	 * @return User
	 * @throws \ES\Kernel\Exception\FileException
	 * @throws \Exception
	 */
	public function createUser(): User;

	/**
	 * @param array $props
	 */
	public function setProperties(array $props);
}