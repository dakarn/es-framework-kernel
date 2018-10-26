<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 02.04.2018
 * Time: 14:53
 */

namespace System\Kernel\TypesApp;

use App\Mail;
use Http\Request\ServerRequest;
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
	/**
	 * @var array
	 */
	const ENV_TYPE = [
		'DEV'  => 'DEV',
		'TEST' => 'TEST',
		'PROD' => 'PROD',
	];

	/**
	 * @var array
	 */
	const APP_TYPE = [
		'Web'     => 'Web',
		'Console' => 'Console',
		'Queue'   => 'Queue',
		'Api'     => 'Api',
		'Auth'    => 'Auth',
	];

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
		if (!isset(self::ENV_TYPE[$env])) {
			throw new \InvalidArgumentException('Try setup invalid environment!');
		}

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
		return $this->getApplicationType() === self::APP_TYPE['Web'];
	}

	/**
	 * @return bool
	 */
	public function isAuthApp(): bool
	{
		return $this->getApplicationType() === self::APP_TYPE['Auth'];
	}

	/**
     * @return bool
     */
	public function isAPIApp(): bool
	{
		return $this->getApplicationType() === self::APP_TYPE['Api'];
	}

    /**
     * @return bool
     */
	public function isConsoleApp(): bool
	{
		return $this->getApplicationType() === self::APP_TYPE['Console'];
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
		if ($this->env == self::ENV_TYPE['DEV'] || $this->env == self::ENV_TYPE['TEST']) {
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