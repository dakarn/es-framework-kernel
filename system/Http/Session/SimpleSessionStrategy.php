<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 30.09.2018
 * Time: 18:31
 */

namespace Http\Session;

class SimpleSessionStrategy implements SessionStrategy
{
	public function get(string $key)
	{

	}

	public function set(string $key, $value)
	{

	}

	public function delete(string $key): bool
	{
		return true;
	}

	public function has(string $key): bool
	{
		return true;
	}
}