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
	private $path;

	private $action;

	private $default;

	private $controller;

	private $param = [];

	private $allow = [];

	private $enterData = [];

	private $isRegex;

	private $middleware = [];

	private $name;

	private $isFilled = false;

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

		$this->isFilled = true;
	}

	public function isFilled(): bool
	{
		return $this->isFilled;
	}

	public function getDefault(): string
	{
		return $this->default;
	}

	public function getName(): string
	{
		return $this->name;
	}

	public function getPath(): string
	{
		return $this->path;
	}

	public function getMiddleware(): array
	{
		return $this->middleware;
	}

	public function getAction(): string
	{
		return $this->action;
	}

	public function getController(): string
	{
		return $this->controller;
	}

	public function getParam(): array
	{
		return $this->param;
	}

	public function getAllow(): array
	{
		return $this->allow;
	}

	public function getEnterData(): array
	{
		return $this->enterData;
	}

	public function isRegex(): bool
	{
		return $this->isRegex;
	}
}