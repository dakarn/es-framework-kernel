<?php

namespace ES\Kernel\System\Router;

use ES\Kernel\Helper\Util;
use ES\Kernel\System\ES;
use ES\Kernel\System\Kernel\GETParam;
use ES\Kernel\Configs\Config;

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
		$path = Util::cutSlash($path);

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
	 * @throws \ES\Kernel\Exception\FileException
	 */
	public static function fillRouterList(): void
	{
		$routers    = Config::getRouters();
		$routerList = new RouterList();

		foreach ($routers as $key => $value) {
			$router = new Router($value);
			$routerList->add($router, $router->getName());
		}

		ES::set(ES::ROUTERS, $routerList);
	}

	/**
	 * @return RouterList
	 * @throws \ES\Kernel\Exception\FileException
	 * @throws \ES\Kernel\Exception\KernelException
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
}