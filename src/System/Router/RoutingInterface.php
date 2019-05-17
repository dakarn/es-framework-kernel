<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 18.04.2018
 * Time: 20:10
 */

namespace System\Router;

interface RoutingInterface
{
	/**
	 * @param array $routers
	 * @param string $path
	 * @return Router
	 */
	public static function findRoute(array $routers, string $path): Router;

	/**
	 * @param Router $router
	 */
	public static function setFoundRouter(Router $router): void;

	/**
	 * @return Router
	 */
	public static function getFoundRouter(): Router;
}