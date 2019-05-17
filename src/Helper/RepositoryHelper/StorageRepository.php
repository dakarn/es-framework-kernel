<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 24.03.2019
 * Time: 22:23
 */

namespace Helper\RepositoryHelper;

class StorageRepository
{
	/**
	 * @var RepositoryInterface[]
	 */
	private static $repositories = [];

	/**
	 * @param string $repository
	 * @return RepositoryInterface
	 */
	public static function getRepository(string $repository): RepositoryInterface
	{
		if (!isset(self::$repositories[$repository])) {
			self::$repositories[$repository] = new $repository();
		}

		return self::$repositories[$repository] ?? null;
	}
}