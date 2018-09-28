<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 02.04.2018
 * Time: 14:53
 */

namespace System\Kernel\TypesApp;

use App\AppKernel;
use System\EventListener\EventManager;
use Http\Response\Response;
use System\Database\DB;
use System\Config;
use System\Database\DatabaseConfigure;

abstract class AbstractApplication
{
	const ENV_TYPE = [
		'DEV'  => 'DEV',
		'TEST' => 'TEST',
		'PROD' => 'PROD',
	];

	const APP_TYPE = [
		'Web'     => 'Web',
		'Console' => 'Console',
		'Queue'   => 'Queue',
		'Api'     => 'Api',
	];

	const PREFIX_ACTION = 'Action';

	protected $env;

	protected $wasRun = false;

	/**
	 * @var EventManager
	 */
	protected $eventManager;

	/**
	 * @var AppKernel
	 */
	protected $appKernel;

	protected $applicationType = '';

	public function __construct()
	{
		DB::setConfigure(new DatabaseConfigure(Config::get('common', 'mysql')));
	}

	public function setEnvironment($env): self
	{
		if (!isset(self::ENV_TYPE[$env])) {
			throw new \InvalidArgumentException('Try setup invalid environment!');
		}

		if (!empty($this->env)) {
			throw new \LogicException('Environment setup already!');
		}

		$this->env = $env;
		return $this;
	}

	public function setApplicationType(string $applicationType): self
	{
		$this->applicationType = $applicationType;
		return $this;
	}

	public function isWebApp(): bool
	{
		return $this->getApplicationType() === self::APP_TYPE['Web'];
	}

	public function isConsoleApp(): bool
	{
		return $this->getApplicationType() === self::APP_TYPE['Console'];
	}

	public function getApplicationType(): string
	{
		return $this->applicationType;
	}

	public function setAppEvent(EventManager $eventManager): self
	{
		$this->eventManager = $eventManager;
		return $this;
	}

	public function getEventApp(): EventManager
	{
		return $this->eventManager;
	}

	public function setAppKernel(AppKernel $appKernel): self
	{
		$this->appKernel = $appKernel;
		return $this;
	}

	public function isRepeatRun()
	{
		if ($this->wasRun) {
			throw new \LogicException('Application was run already. A repeat run is impossible!');
		}

		$this->wasRun = true;
	}

	public function getEnvironment(): string
	{
		return $this->env;
	}

	public function outputException(\Throwable $e)
	{
		if ($this->env == self::ENV_TYPE['DEV'] || $this->env == self::ENV_TYPE['TEST']) {
			throw $e;
		} else {
			if($this->isWebApp()) {
				(new Response())->redirect(URL);
			}
		}
	}

	abstract public function run();
}