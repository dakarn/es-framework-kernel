<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 26.03.2019
 * Time: 21:54
 */

namespace System\Auth\Authentication\Processes;

use Models\User\UserInterface;
use System\Auth\ClientAppRepository;

class FillingPayload
{
	/**
	 * @param ClientAppRepository $clientAppRepository
	 * @param UserInterface $user
	 * @param int $now
	 * @param int $ttl
	 * @return array
	 */
	protected function fillPayload(ClientAppRepository $clientAppRepository, UserInterface $user, int $now, int $ttl): array
	{
		return [
			'sub'     => $clientAppRepository->getResult()->getType(),
			'iss'     => $clientAppRepository->getResult()->getSite(),
			'userId'  => $user->getUserId(),
			'email'   => $user->getEmail(),
			'role'    => $user->getRole(),
			'login'   => $user->getLogin(),
			'created' => $user->getCreated(),
			'iat'     => $now,
			'exp'     => $now + $ttl,
		];
	}
}