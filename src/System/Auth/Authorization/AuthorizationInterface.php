<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 10.10.2018
 * Time: 20:25
 */

namespace ES\Kernel\System\Auth\Authorization;

interface AuthorizationInterface
{
	/**
	 * @throws \ES\Kernel\Exception\FileException
	 */
	public function verifyAccess(): AuthorizationInterface;

	/**
	 * @return bool
	 */
	public function isAccess(): bool;

	/**
	 * @param int $checkRole
	 * @param int $userRole
	 * @return bool
	 */
	public function isGranted(int $checkRole, int $userRole): bool;

	/**
	 * @return Authorization
	 */
	public function verifyAccessByUserId(): AuthorizationInterface;
}