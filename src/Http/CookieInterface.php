<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 10.10.2018
 * Time: 20:02
 */

namespace Http;

interface CookieInterface
{
	/**
	 * @param string $key
	 * @return string
	 */
	public function get(string $key): string;

	/**
	 * @param string $key
	 * @return bool
	 */
	public function has(string $key): bool;

	/**
	 * @param array $keys
	 * @return array
	 */
	public function getSome(array $keys): array;

	/**
	 * @return array
	 */
	public function getAll(): array;

	/**
	 * @param string $key
	 */
	public function remove(string $key);

	/**
	 * @param string $key
	 * @param string $value
	 * @param string $path
	 * @param int $expire
	 * @param string $domain
	 * @return Cookie
	 */
	public function set(string $key, string $value, string $path = '', int $expire = 0, string $domain = ''): Cookie;
}