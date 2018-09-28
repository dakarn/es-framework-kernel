<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 18.03.2018
 * Time: 1:55
 */

namespace Http\Response;

use Exception\ResponseException;
use Exception\RoutingException;
use Helper\Cookie;
use System\Router\Routing;

class Response
{
	private $responseType;

	/**
	 * @var ResponseInterface
	 */
	private $response;

	private $data;

	private $param;

	private $headers = [];

	private $template;

	private $cookies = [];

	private $status = [];

	public function __construct()
	{
	}

	public function getData()
	{
		return $this->data;
	}

	public function setData($data = null, string $responseType = 'simple', array $param = []): Response
	{
		$this->param        = $param;
		$this->data         = $this->data . $data;
		$this->responseType = $responseType;
		return $this;
	}

	public function render(): Response
	{
		$this->selectResponse();

		echo $this->response->render($this->data, $this->param);
		return $this;
	}

	public function withHeader(string $name, string $value): Response
	{
		$this->headers[$name] = $value;
		return $this;
	}

	public function withCookie(string $name, string $value): Response
	{
		$this->cookies[$name] = $value;
		return $this;
	}

	public function withTemplate(string $template): Response
	{
		$this->template = $template;
		return $this;
	}

	public function withStatus(string $code, string $text): Response
	{
		$this->status[$code] = $text;
		return $this;
	}

	public function sendHeaders()
	{
		foreach ($this->headers as $headerKey => $header) {
			header($headerKey . ': ' . $header, false);
		}

		foreach ($this->cookies as $cookieKey => $cookie) {
			Cookie::create()->set($cookieKey, $cookie);
		}
	}

	public function redirect(string $url): void
	{
		header('Location: ' . $url);
		exit;
	}

	public function redirectToRoute(string $routerName, array $arguments, int $status): void
	{
		$router = Routing::getRouterList()->get($routerName);

		if (!empty($router)) {
			$url = URL . Routing::replaceRegexToParam($router->getPath(), $router->getParam(), $arguments);
			header('Location: ' . $url, true, $status);
			exit;
		}

		throw RoutingException::notFound([$routerName]);
	}

	private function selectResponse(): void
	{
		switch ($this->responseType) {
			case 'simple':
				$this->response = new SimpleResponse();
				break;
			case 'json':
				$this->response = new JsonResponse();
				break;
			case 'api':
				$this->response = new ApiResponse();
				break;
			case 'xml':
				$this->response = new XMLResponse();
				break;
			default:
				throw ResponseException::invalidResponse();
				break;
		}
	}
}