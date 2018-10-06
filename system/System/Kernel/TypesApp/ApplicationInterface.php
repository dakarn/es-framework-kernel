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
	public function isAuthApp(): bool;

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
	 * @return EventManager
	 */
	public function getEventApp(): EventManager;

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