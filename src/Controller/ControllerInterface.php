<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 16.03.2018
 * Time: 20:33
 */

namespace ES\Kernel\Controller;

use ES\Kernel\Http\Request\ServerRequest;
use ES\Kernel\EventListener\EventManager;
use ES\Kernel\Http\Response\Response;
use ES\Kernel\Router\RouteData;

interface ControllerInterface
{
	/**
	 * @param RouteData $route
	 * @return mixed
	 */
	public function __before(RouteData $route);

	/**
	 * @param RouteData $route
	 * @return mixed
	 */
	public function __after(RouteData $route);

	/**
	 * ControllerInterface constructor.
	 * @param EventManager $eventManager
	 * @param Response $response
	 * @param ServerRequest $request
	 */
	public function __construct(EventManager $eventManager, Response $response, ServerRequest $request);

	/**
	 *
	 */
	public function __destruct();
}