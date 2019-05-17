<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 06.10.2018
 * Time: 22:37
 */

namespace System\Auth\Authentication;

use App\Models\AuthAppRepository;
use Models\User\UserInterface;

interface AuthenticationInterface
{
	/**
	 * @param UserInterface $user
	 * @return Authentication
	 */
	public function setCurrentUser(UserInterface $user): AuthenticationInterface;

	/**
	 * @return Authentication
	 * @throws \Exception\FileException
	 */
	public function processLogout(): AuthenticationInterface;

	/**
	 * @param UserInterface $user
	 * @return Authentication
	 */
	public function processAuthentication(UserInterface $user): AuthenticationInterface;

	/**
	 * @param UserInterface $user
	 * @return Authentication
	 */
	public function processAuthByUserId(UserInterface $user): AuthenticationInterface;

	/**
	 * @return bool
	 */
	public function isAuth(): bool;

	/**
	 * @return bool
	 */
	public function isLogout(): bool;
}