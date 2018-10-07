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
use System\Render;
use System\Router\Routing;

class Response implements ResponseInterface
{
	/**
	 * @var FormatResponseInterface
	 */
	private $formatterType;

	/**
	 * @var string
	 */
	private $data = '';

	/**
	 * @var array
	 */
	private $headers = [];

	/**
	 * @var string
	 */
	private $template = '';

	/**
	 * @var array
	 */
	private $cookies = [];

	/**
	 * @var array
	 */
	private $status = [];

	/**
	 * Response constructor.
	 */
	public function __construct()
	{
	}

	/**
	 * @return Response
	 */
	public function setAccessOrigin(): Response
	{
		return $this;
	}

	/**
	 * @return string
	 */
	public function getBody(): string
	{
		return $this->data;
	}

	public function getStatusCode(): string
    {
        return $this->status[0];
    }

    /**
	 * @param FormatResponseInterface $formatted
	 * @return Response
	 */
	public function withBody(FormatResponseInterface $formatted): Response
	{
		$this->formatterType = $formatted;
		$this->data          = $formatted->getFormattedText();

		return $this;
	}

	/**
	 * @return Response
	 */
	public function output(): Response
	{
		echo $this->data;
		return $this;
	}

    /**
     * @return string
     */
	public function returnOutput(): string
	{
		return $this->data;
	}

	/**
	 * @param string $name
	 * @param string $value
	 * @return Response
	 */
	public function withHeader(string $name, string $value): Response
	{
		$this->headers[$name] = $value;
		return $this;
	}

    /**
     * @param string $files
     * @return Response
     */
	public function withFiles(string $files): Response
    {
        return $this;
    }

    /**
	 * @param string $name
	 * @param string $value
	 * @return Response
	 */
	public function withCookie(string $name, string $value): Response
	{
		$this->cookies[$name] = $value;
		return $this;
	}

	/**
	 * @param string $template
	 * @return Response
	 */
	public function withTemplate(string $template): Response
	{
		$this->template = $template;
		return $this;
	}

	/**
	 * @param string $code
	 * @param string $text
	 * @return Response
	 */
	public function withStatus(string $code, string $text): Response
	{
		$this->status[$code] = $text;
		return $this;
	}

	public function getReasonPhrase(): string
    {
        return '';
    }

    /**
	 * @return bool
	 */
	public function sendHeaders(): bool
	{
		foreach ($this->headers as $headerKey => $header) {
			header($headerKey . ': ' . $header, false);
		}

		foreach ($this->cookies as $cookieKey => $cookie) {
			Cookie::create()->set($cookieKey, $cookie);
		}

		return true;
	}

	/**
	 * @param string $url
	 */
	public function redirect(string $url): void
	{
		header('Location: ' . $url);
		exit;
	}

	/**
	 * @param string $routerName
	 * @param array $arguments
	 * @param int $status
	 * @throws RoutingException
	 * @throws \Exception\FileException
	 * @throws \Exception\KernelException
	 */
	public function redirectToRoute(string $routerName, array $arguments, int $status): void
	{
		$router = Routing::getRouterList()->get($routerName);

		if (!empty($router)) {
			$url = URL . Routing::replaceRegexToParam($router->getPath(), $router->getParam(), $arguments);
			header('Location: ' . $url, true, $status);
			exit;
		}

		//throw RoutingException::notFound([$routerName]);
	}
}