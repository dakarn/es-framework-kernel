<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 02.04.2018
 * Time: 14:53
 */

namespace ES\Kernel\Kernel\TypesApp;

use ES\Kernel\EventListener\EventManager;
use ES\Kernel\Configs\Config;
use ES\Kernel\Logger\Logger;
use ES\Kernel\Logger\LoggerAware;
use ES\Kernel\Helper\ES;

abstract class AbstractApplication implements ApplicationInterface
{
	public const ENV_PROD = 'PROD';
	public const ENV_BETA = 'BETA';
	public const ENV_DEV  = 'DEV';

	public const APP_TYPE_WEB     = 'Web';
	public const APP_TYPE_CONSOLE = 'Console';
	public const APP_TYPE_API     = 'Api';
	public const APP_TYPE_AUTH    = 'Auth';

	/**
	 * @var string
	 */
	const PREFIX_ACTION = 'Action';

    /**
     * @var string
     */
	protected $env;

    /**
     * @var bool
     */
	protected $wasRun = false;

	/**
	 * @var EventManager
	 */
	protected $eventManager;

    /**
     * @var string
     */
	protected $applicationType = '';

    /**
     * AbstractApplication constructor.
     */
	public function __construct()
	{
		ES::set(ES::APP, $this);

		$this->setupClass();
		$this->setupErrorHandler();
		$this->setupShutdownFunction();
	}

	/**
	 * @return AbstractApplication
	 */
	public function setupErrorHandler(): self
	{
		//\set_exception_handler(function($e) {
		//	$this->outputException($e);
		//});

		//\set_error_handler(function($errno, $errstr, $errfile, $errline) {
		//	$this->outputError($errno, $errstr, $errfile, $errline);
		//});

		return $this;
	}

	/**
	 * @return AbstractApplication
	 */
	public function setupShutdownFunction(): self
	{
		//\register_shutdown_function(function() {
		//	ShutdownScript::run();
		//});

		return $this;
	}

	/**
	 * @return void
	 */
	public function outputResponse(): void
	{
	}

    /**
     * @param $env
     * @return AbstractApplication
     */
	public function setEnvironment($env): self
	{
		if (!empty($this->env)) {
			throw new \LogicException('Environment setup already!');
		}

		$this->env = $env;
		return $this;
	}

    /**
     * @param string $applicationType
     * @return AbstractApplication
     */
	public function setApplicationType(string $applicationType): self
	{
		$this->applicationType = $applicationType;
		return $this;
	}

    /**
     * @return bool
     */
	public function isWebApp(): bool
	{
		return $this->applicationType === self::APP_TYPE_WEB;
	}

	/**
	 * @return bool
	 */
	public function isAuthApp(): bool
	{
		return $this->applicationType === self::APP_TYPE_AUTH;
	}

	/**
     * @return bool
     */
	public function isAPIApp(): bool
	{
		return $this->applicationType === self::APP_TYPE_API;
	}

    /**
     * @return bool
     */
	public function isConsoleApp(): bool
	{
		return $this->applicationType === self::APP_TYPE_CONSOLE;
	}

    /**
     * @return string
     */
	public function getApplicationType(): string
	{
		return $this->applicationType;
	}

    /**
     * @return EventManager
     */
	public function getEventApp(): EventManager
	{
		return $this->eventManager;
	}

    /**
     * @return void
     */
	public function isRepeatRun()
	{
		if ($this->wasRun) {
			throw new \LogicException('Application was run already. A repeat run is impossible!');
		}

		$this->wasRun = true;
	}

    /**
     * @return string
     */
	public function getEnvironment(): string
	{
		return $this->env;
	}

	/**
	 * @param \Throwable $e
	 * @throws \Throwable
	 * @return void
	 */
	public function outputException(\Throwable $e): void
	{
		if ($this->env == self::ENV_DEV) {
			$this->customOutputError($e);
		} else {
			$this->customOutputError($e);
		}

		/*Mail::create()
			->setTo('admin@es-framework.ru')
			->setSubject('Error on ' . ServerRequest::create()->getHost())
			->setFrom('admin@es-framework.ru')
			->asHtml()
			->setTemplate()
			->send();*/
	}

	/**
	 * @param $errno
	 * @param $errstr
	 * @param $errfile
	 * @param $errline
	 * @throws \Exception
	 */
	public function outputError($errno, $errstr, $errfile, $errline): void
	{
		throw new \Exception('in ' . $errfile . ' on line ' . $errline);
	}

	/**
	 * @param string $level
	 * @param string $message
	 * @return void
	 */
	protected function log(string $level, string  $message): void
	{
		LoggerAware::setlogger(Logger::class)->log($level, $message);
	}

    /**
     *
     */
	protected function runInternal(): void
    {
        Config::setEnvForConfig($this->env);
    }

    abstract public function terminate();

	abstract public function run();

	abstract public function setupClass();

	abstract public function customOutputError(\Throwable $e);
}