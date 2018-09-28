<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 09.03.2018
 * Time: 1:47
 */

namespace System\Router;

class RouteData
{
	private $data = [];

	public function setData(string $key, string $text): self
	{
		$this->data[$key] = $text;
		return $this;
	}

	public function getActionName(): string
	{
		return $this->data['action'] ?? '';
	}

	public function getControllerName(): string
	{
		return $this->data['controller'] ?? '';
	}
}