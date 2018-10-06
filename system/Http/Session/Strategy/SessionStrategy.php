<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 30.09.2018
 * Time: 18:31
 */

namespace Http\Session\Strategy;

interface SessionStrategy
{
	/**
	 * @param string $key
	 * @return mixed
	 */
	public function get($key);

	/**
	 * @param string $key
	 * @return bool
	 */
	public function has($key): bool;

	/**
	 * @param string $key
	 * @return bool
	 */
	public function delete($key): bool;

	/**
	 * @param string $key
	 * @param $value
	 * @return mixed
	 */
	public function set($key, $value);

	/**
	 * @param string $key
	 * @return array
	 */
	public function getAsArray($key): array;

	/**
	 * @return int
	 */
	public function count(): int;

	/**
	 * @param array $keys
	 * @return array
	 */
	public function getSome(array $keys): array;

	/**
	 * @return void
	 */
	public function clear();

	/**
	 * @return array
	 */
	public function all(): array;
}