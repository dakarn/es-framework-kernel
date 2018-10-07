<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 19.03.2018
 * Time: 20:35
 */

namespace System\Router;

class Router
{
	/**
	 * @var mixed|string
	 */
	private $path;

	/**
	 * @var mixed|string
	 */
	private $action;

	/**
	 * @var mixed|string
	 */
	private $default;

	/**
	 * @var mixed|string
	 */
	private $controller;

	/**
	 * @var array|mixed
	 */
	private $param = [];

	/**
	 * @var array|mixed
	 */
	private $allow = [];

	/**
	 * @var array|mixed
	 */
	private $enterData = [];

	/**
	 * @var bool|mixed
	 */
	private $isRegex;

	/**
	 * @var array|mixed
	 */
	private $middleware = [];

	/**
	 * @var mixed|string
	 */
	private $name;

	/**
	 * @var int
	 */
	private $access = 0;

	/**
	 * @var bool
	 */
	private $isFilled = false;

	/**
	 * Router constructor.
	 * @param array $router
	 */
	public function  __construct(array $router = [])
	{
		if (empty($router)) {
			return;
		}

		$this->param      = $router['param'] ?? [];
		$this->path       = $router['path'] ?? '';
		$this->action     = $router['action'] ?? '';
		$this->controller = $router['controller'] ?? '';
		$this->enterData  = $router['enterData'] ?? [];
		$this->default    = $router['default'] ?? '';
		$this->allow      = $router['allow'] ?? [];
		$this->middleware = $router['middleware'] ?? [];
		$this->isRegex    = $router['regex'] ?? false;
		$this->name       = $router['name'] ?? '';
		$this->access     = $router['access'] ?? '';

		$this->isFilled = true;
	}

	/**
	 * @return bool
	 */
	public function isFilled(): bool
	{
		return $this->isFilled;
	}

	/**
	 * @return string
	 */
	public function getDefault(): string
	{
		return $this->default;
	}

	/**
	 * @return int
	 */
	public function getAccess(): int
	{
		return $this->access;
	}

	/**
	 * @return string
	 */
	public function getName(): string
	{
		return $this->name;
	}

	/**
	 * @return string
	 */
	public function getPath(): string
	{
		return $this->path;
	}

	/**
	 * @return array
	 */
	public function getMiddleware(): array
	{
		return $this->middleware;
	}

	/**
	 * @return string
	 */
	public function getAction(): string
	{
		return $this->action;
	}

	/**
	 * @return string
	 */
	public function getController(): string
	{
		return $this->controller;
	}

	/**
	 * @return array
	 */
	public function getParam(): array
	{
		return $this->param;
	}

	/**
	 * @return array
	 */
	public function getAllow(): array
	{
		return $this->allow;
	}

	/**
	 * @return array
	 */
	public function getEnterData(): array
	{
		return $this->enterData;
	}

	/**
	 * @return bool
	 */
	public function isRegex(): bool
	{
		return $this->isRegex;
	}
}