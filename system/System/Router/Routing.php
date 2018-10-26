<?php

namespace System\Router;

use System\ES;
use System\Kernel\GETParam;
use Configs\Config;

class Routing implements RoutingInterface
{
	/**
	 * @var string
	 */
	const DEFAULT_ROUTE_NAME = 'default';

	/**
	 * @var bool
	 */
	private static $isFound = false;

	/**
	 * @var Router
	 */
	private static $foundRouter;

	/**
	 * @param array $routers
	 * @param string $path
	 * @return Router
	 */
	public static function findRoute(array $routers, string $path): Router
	{
		$path = self::cutSlash($path);

		foreach ($routers as $router) {

			$router = new Router($router);

			if ($router->isRegex()) {
				self::findRouterByRegex($router, $path);
			} else if ($router->getPath() === $path) {
				self::$isFound = true;
			}

			if (self::$isFound) {
				return $router;
			}
		}

		if (!self::$isFound) {
			return new Router();
		}

		return new Router();
	}

	/**
	 * @param Router $router
	 */
	public static function setFoundRouter(Router $router): void
	{
		self::$foundRouter = $router;
	}

	/**
	 * @return Router
	 */
	public static function getFoundRouter(): Router
	{
		return self::$foundRouter;
	}

	/**
	 * @throws \Exception\FileException
	 */
	public static function fillRouterList(): void
	{
		$routers    = Config::getRouters();
		$routerList = new RouterList();

		foreach ($routers as $key => $value) {
			$router = new Router($value);
			$routerList->add($router->getName(), $router);
		}

		ES::set(ES::ROUTERS, $routerList);
	}

	/**
	 * @return RouterList
	 * @throws \Exception\FileException
	 * @throws \Exception\KernelException
	 */
	public static function getRouterList(): RouterList
	{
		if (!ES::has(ES::ROUTERS)) {
			self::fillRouterList();
		}

		return ES::get(ES::ROUTERS);
	}

	/**
	 * @param Router $router
	 * @param string $path
	 * @return bool
	 */
	public static function findRouterByRegex(Router $router, string $path): bool
	{
		$regexPath  = $router->getPath();
		$nameParams = [];

		foreach ($router->getParam() as $key => $p) {
			$regexPath    = \str_replace('{' . $key . '}', '('.$p.')', $regexPath);
			$nameParams[] = $key;
		}

		if (\preg_match('|^' . $regexPath . '$|', $path, $result)) {
			GETParam::setParamForController($nameParams, $result);
			self::$isFound = true;
			return true;
		}

		return false;
	}

	/**
	 * @param string $path
	 * @param array $params
	 * @param array $params1
	 * @return string
	 */
	public static function replaceRegexToParam(string $path, array $params, array $params1): string
	{
		$path1 = $path;

		foreach ($params as $index => $param) {
			$params[$index] = $params1[$index];
			$path1          = \str_replace('{' . $index . '}', $params[$index], $path1);
		}

		return $path1;
	}

	/**
	 * @param string $path
	 * @return string
	 */
	private static function cutSlash(string $path): string
	{
		if (\substr($path, -1) == '/') {
			$path = \substr($path, 0 , -1);
		}

		return $path;
	}
}