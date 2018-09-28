<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 18.04.2018
 * Time: 20:22
 */

namespace System\Kernel\TypesApp;

use App\AppKernel;
use System\EventListener\EventManager;

interface ApplicationInterface
{
	/**
	 * @param $env
	 * @return AbstractApplication
	 */
	public function setEnvironment($env): AbstractApplication;

	/**
	 * @param string $applicationType
	 * @return AbstractApplication
	 */
	public function setApplicationType(string $applicationType): AbstractApplication;

	/**
	 * @return bool
	 */
	public function isWebApp(): bool;

	/**
	 * @return bool
	 */
	public function isAPIApp(): bool;

	/**
	 * @return bool
	 */
	public function isConsoleApp(): bool;

	/**
	 * @return string
	 */
	public function getApplicationType(): string;

	/**
	 * @param EventManager $eventManager
	 * @return AbstractApplication
	 */
	public function setAppEvent(EventManager $eventManager): AbstractApplication;

	/**
	 * @return EventManager
	 */
	public function getEventApp(): EventManager;

	/**
	 * @param AppKernel $appKernel
	 * @return AbstractApplication
	 */
	public function setAppKernel(AppKernel $appKernel): AbstractApplication;

	/**
	 * @return string
	 */
	public function getEnvironment(): string;

	/**
	 * @param \Throwable $e
	 * @return mixed
	 */
	public function outputException(\Throwable $e);
}