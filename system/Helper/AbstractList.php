<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 19.03.2018
 * Time: 21:01
 */

namespace Helper;

abstract class AbstractList
{
	protected $list = [];

	public function add($key, $value): self
	{
		$this->list[$key] = $value;
		return $this;
	}

	public function has($key): bool
	{
		return isset($this->list[$key]);
	}

	public function isEmpty(): bool
	{
		return !empty($this->list);
	}

	public function count(): bool
	{
		return count($this->list);
	}

	public function get($key)
	{
		return isset($this->list[$key]) ? $this->list[$key] : null;
	}

	public function getAll($key): array
	{
		return $this->list[$key];
	}

	public function delete($key): bool
	{
		if (isset($this->list[$key])) {
			unset($this->list[$key]);
			return true;
		}

		return false;
	}

	public function clearAll()
	{
		$this->list = [];
	}
}