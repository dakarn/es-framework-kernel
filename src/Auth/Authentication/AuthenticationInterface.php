<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 06.10.2018
 * Time: 22:37
 */

namespace ES\Kernel\Auth\Authentication;

use ES\Kernel\Models\User\UserInterface;
use ES\Kernel\Validators\AbstractValidator;

interface AuthenticationInterface
{
	/**
	 * @param UserInterface $user
	 * @return Authentication
	 */
	public function setCurrentUser(UserInterface $user): AuthenticationInterface;

	/**
	 * @return Authentication
	 * @throws \ES\Kernel\Exception\FileException
	 */
	public function processLogout(): AuthenticationInterface;

	/**
	 * @param UserInterface $user
	 * @param AbstractValidator $validator
	 * @return AuthenticationInterface
	 */
	public function processAuthentication(UserInterface $user, AbstractValidator $validator): AuthenticationInterface;

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