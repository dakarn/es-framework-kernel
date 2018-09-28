<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 16.03.2018
 * Time: 20:33
 */

namespace System\Controller;

use Http\Request\ServerRequest;
use System\EventListener\EventManager;
use Http\Response\Response;
use System\Router\RouteData;

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