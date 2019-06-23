<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 24.03.2019
 * Time: 22:23
 */

namespace ES\Kernel\Helper\RepositoryHelper;

use ES\Kernel\Auth\ClientAppRepository;
use ES\Kernel\Auth\TokenRepository;
use ES\Kernel\UserManager\UserRepository;

class StorageRepository
{
	/**
	 * @var RepositoryInterface
	 */
	private static $repositories = [];

    /**
     * @return UserRepository|RepositoryInterface
     */
	public static function getUserRepository(): UserRepository
    {
        return self::getRepository(UserRepository::class);
    }

    /**
     * @return TokenRepository|RepositoryInterface
     */
    public static function getTokenRepository(): TokenRepository
    {
        return self::getRepository(TokenRepository::class);
    }

    /**
     * @return ClientAppRepository|RepositoryInterface
     */
    public static function getClientAppRepository(): ClientAppRepository
    {
        return self::getRepository(ClientAppRepository::class);
    }

	/**
	 * @param string $repository
	 * @return RepositoryInterface
	 */
	private static function getRepository(string $repository): RepositoryInterface
	{
		if (!isset(self::$repositories[$repository])) {
			self::$repositories[$repository] = new $repository();
		}

		return self::$repositories[$repository] ?? null;
	}
}