<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 18.03.2018
 * Time: 1:54
 */

namespace Http\Request;

use App\AppKernel;
use Traits\SingletonTrait;
use Helper\Cookie;
use Helper\Session;
use Middleware\StorageMiddleware;
use Exception\ResponseException;
use Middleware\RequestHandler;
use Http\Response\Response;

class Request implements RequestInterface
{
	use SingletonTrait;

	private $headers   = [];
	private $method    = '';
	private $host      = '';
	private $path      = '';
	private $scheme    = '';
	private $cookies   = [];
	private $referer   = '';
	private $userAgent = '';
	private $proxy     = '';

	/**
	 * @var  Response
	 */
	private $rresponse;

	public function handle(AppKernel $appKernel)
	{
		StorageMiddleware::add($appKernel->getMiddlewares());

		if (!isset(StorageMiddleware::get()[0])) {
			throw ResponseException::invalidResponse();
		}

		$runHandler = new RequestHandler();
		$this->rresponse = $runHandler->handle(Request::create(), $runHandler);
	}

	public function resultHandle(): Response
	{
		return $this->rresponse;
	}

	public function getHeaders(): array
	{
		return !empty($this->headers) ? $this->headers: $_SERVER;
	}

	public function getHeader(string $item): string
	{
		return $_SERVER[$item] ?? '';
	}

	public function getUserIp(): string
	{
		return $_SERVER['REMOTE_ADDR'];
	}

	public function getHost(): string
	{
		return $this->getProperty('host', 'HTTP_HOST');
	}

	public function getReferer(): string
	{
		return $this->getProperty('referer', 'HTTP_REFERER');
	}

	public function getUserAgent(): string
	{
		return $this->getProperty('userAgent', 'HTTP_USER_AGENT');
	}

	public function getMethod(): string
	{
		return $this->getProperty('method', 'REQUEST_METHOD');
	}

	public function getPath(): string
	{
		return $this->path;
	}

	public function getPProxy(): string
	{
		return $this->proxy;
	}

	public function getScheme(): string
	{
		return $this->scheme;
	}

	public function takePost($key): string
	{
		return $_POST[$key] ?? '';
	}

	public function takeAny($key): string
	{
		return $this->takePost($key) ?: ($this->takeGet($key) ?: '');
	}

	public function takeGet($key): string
	{
		return $_GET[$key] ?? '';
	}

	public function isAjax(): bool
	{
		return isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest';
	}

	public function getQueryString(): string
	{
		return $_SERVER['QUERY_STRING'];
	}

	public function getRequestUri(): string
	{
		return $_SERVER['REQUEST_URI'];
	}

	public function getCookie(): Cookie
	{
		return Cookie::create();
	}

	public function getSession(): Session
	{
		return Session::create();
	}

	public function setMethod(string $method): self
	{
		$this->method = $method;
		return $this;
	}

	public function setHost(string $host): self
	{
		$this->host = $host;
		return $this;
	}

	public function setPath(string $path): self
	{
		$this->path = $path;
		return $this;
	}

	public function setHeader(string $name, string $value): self
	{
		$this->headers[$name] = $value;
		return $this;
	}

	public function setReferer(string $referer): self
	{
		$this->referer = $referer;
		return $this;
	}

	public function setUserAgent(string $userAgent): self
	{
		$this->userAgent = $userAgent;
		return $this;
	}

	public function setProxy(string $proxy): self
	{
		$this->proxy = $proxy;
		return $this;
	}

	public function setScheme(string $scheme): self
	{
		$this->scheme = $scheme;
		return $this;
	}

	public function setCookie(array $cookies): self
	{
		$this->cookies = $cookies;
		return $this;
	}

	private function getProperty(string $property, string $default = '')
	{
		return !empty($this->{$property}) ? $this->headers: ($_SERVER[$default] ?? '');
	}
}