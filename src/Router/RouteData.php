<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 09.03.2018
 * Time: 1:47
 */

namespace ES\Kernel\Router;

class RouteData
{
	/**
	 * @var array
	 */
	private $data = [];

	/**
	 * @param string $key
	 * @param string $text
	 * @return RouteData
	 */
	public function setData(string $key, string $text): self
	{
		$this->data[$key] = $text;
		return $this;
	}

	/**
	 * @return string
	 */
	public function getActionName(): string
	{
		return $this->data['action'] ?? '';
	}

	/**
	 * @return string
	 */
	public function getControllerName(): string
	{
		return $this->data['controller'] ?? '';
	}
}