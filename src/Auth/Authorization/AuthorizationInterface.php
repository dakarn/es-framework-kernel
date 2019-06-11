<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 10.10.2018
 * Time: 20:25
 */

namespace ES\Kernel\Auth\Authorization;

use ES\Kernel\Exception\FileException;
use ES\Kernel\UserManager\User;

interface AuthorizationInterface
{
	/**
	 * @throws FileException
	 */
	public function verifyAccess(): AuthorizationInterface;

	/**
	 * @return bool
	 */
	public function isAccess(): bool;

    /**
     * @param int $checkRole
     * @param User $user
     * @return bool
     */
	public function isGranted(int $checkRole, User $user): bool;

	/**
	 * @return Authorization
	 */
	public function verifyAccessByUserId(): AuthorizationInterface;
}