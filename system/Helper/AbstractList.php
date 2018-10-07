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
	/**
	 * @var array
	 */
	protected $list = [];

	/**
	 * @param $key
	 * @param $value
	 * @return AbstractList
	 */
	public function add($key, $value): self
	{
		$this->list[$key] = $value;
		return $this;
	}

	/**
	 * @return mixed
	 */
	public function getFirstElement()
	{
		$list = $this->list;
		return \array_shift($list);
	}

	/**
	 * @return mixed
	 */
	public function getEndElement()
	{
		$list = $this->list;
		return \array_pop($list);
	}

	/**
	 * @param $key
	 * @return bool
	 */
	public function has($key): bool
	{
		return isset($this->list[$key]);
	}

	/**
	 * @return bool
	 */
	public function isEmpty(): bool
	{
		return !empty($this->list);
	}

	/**
	 * @return bool
	 */
	public function count(): bool
	{
		return \count($this->list);
	}

	/**
	 * @param $key
	 * @return mixed|null
	 */
	public function get($key)
	{
		return isset($this->list[$key]) ? $this->list[$key] : null;
	}

	/**
	 * @param $key
	 * @return array
	 */
	public function getAll($key): array
	{
		return $this->list[$key];
	}

	/**
	 * @param $key
	 * @return bool
	 */
	public function delete($key): bool
	{
		if (isset($this->list[$key])) {
			unset($this->list[$key]);
			return true;
		}

		return false;
	}

	/**
	 * @return void
	 */
	public function clearAll(): void
	{
		$this->list = [];
	}
}