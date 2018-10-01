<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 30.09.2018
 * Time: 18:31
 */

namespace Http\Session;

interface SessionStrategy
{
	public function get(string $key);

	public function has(string $key): bool;

	public function delete(string $key): bool;

	public function set(string $key, $value);
}