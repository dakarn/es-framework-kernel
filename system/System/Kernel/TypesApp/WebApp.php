<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 02.04.2018
 * Time: 14:53
 */

namespace System\Kernel\TypesApp;

use App\AppKernel;
use Exception\ExceptionListener\ExceptionListener;
use Http\Request\ServerRequest;
use Http\Middleware\StorageMiddleware;
use Providers\StorageProviders;
use Http\Response\Response;
use System\Database\DB;
use System\EventListener\EventTypes;
use System\Logger\LoggerStorage;
use System\Logger\LogLevel;

final class WebApp extends AbstractApplication
{
	/**
	 * @var Response
	 */
	private $response;

    /**
     * @var ServerRequest
     */
	private $request;

	/**
	 * @param AppKernel $appKernel
	 * @return AbstractApplication
	 */
	public function setAppKernel(AppKernel $appKernel): AbstractApplication
	{
		parent::setAppKernel($appKernel);
		StorageProviders::add($appKernel->getProviders());
		StorageMiddleware::add($appKernel->getMiddlewares());

		return $this;
	}

	/**
	 * @return WebApp
	 */
	public function handle(): WebApp
	{
		$this->request = ServerRequest::fromGlobal()->handle();

		return $this;
	}

	/**
	 * @return void
	 */
	public function run(): void
	{
	    $this->runInternal();

		try {
			$this->handle();
		} catch(\Throwable $e) {
			$this->log(LogLevel::ERROR, $e->getTraceAsString());
			new ExceptionListener($e);
			$this->outputException($e);
		}
	}

	/**
	 * @return void
	 */
	public function outputResponse(): void
	{
		$this->response = $this->request->resultHandle();

		$this->response->sendHeaders();
		$this->response->output();

		$this->eventManager->runEvent(EventTypes::AFTER_OUTPUT_RESPONSE);
	}

	/**
	 * @return void
	 */
	public function terminate(): void
	{
		DB::disconnect();
		LoggerStorage::create()->releaseLog();
	}
}