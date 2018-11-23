<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 02.04.2018
 * Time: 14:53
 */

namespace System\Kernel\TypesApp;

use System\Database\DbConfigLogic\DbConfig;
use System\EventListener\EventManager;
use System\Database\DB;
use Configs\Config;
use System\Database\DbConfigLogic\DatabaseConfigure;
use System\Logger\Logger;
use System\Logger\LoggerAware;
use System\ES;

abstract class AbstractApplication implements ApplicationInterface
{
	public const ENV_PROD = 'PROD';
	public const ENV_BETA = 'BETA';
	public const ENV_DEV  = 'DEV';

	public const APP_TYPE_WEB     = 'Web';
	public const APP_TYPE_CONSOLE = 'Console';
	public const APP_TYPE_QUEUE   = 'Queue';
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
		LoggerAware::setlogger(new Logger())->log($level, $message);
	}

	/**
	 * @throws \Exception\FileException
	 */
	protected function runInternal(): void
    {
        Config::setEnvForConfig($this->env);

	    $dbConfig = Config::get('db');

        DbConfig::create()
            ->setConfigure(DB::MYSQL, new DatabaseConfigure($dbConfig['mysql']))
            ->setConfigure(DB::MSSQL, new DatabaseConfigure($dbConfig['mssql']))
            ->setConfigure(DB::PGSQL, new DatabaseConfigure($dbConfig['pgsql']))
            ->setConfigure(DB::ORACLE, new DatabaseConfigure($dbConfig['oracle']));
    }

    abstract public function terminate();

	abstract public function run();

	abstract public function setupClass();

	abstract public function customOutputError(\Throwable $e);
}