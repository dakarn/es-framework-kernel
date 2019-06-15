<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 18.03.2018
 * Time: 1:55
 */

namespace ES\Kernel\Http\Response;

use ES\Kernel\Http\Cookie;
use ES\Kernel\Helper\Constants;
use ES\Kernel\Helper\Render;
use ES\Kernel\Router\Routing;

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
	 * @param int $expire
	 * @param string $path
	 * @param string $domain
	 * @return Response
	 */
	public function withCookie(string $name, string $value, int $expire = 0, string $path = '/', string $domain = Constants::COMMON_URL): Response
	{
		$this->cookies[] = [
			'name'   => $name,
			'value'  => $value,
			'expire' => $expire,
			'path'   => $path,
			'domain' => $domain,
		];

		return $this;
	}

	/**
	 * @param string $template
	 * @return Response
	 * @throws \ES\Kernel\Exception\FileException
	 */
	public function withTemplate(string $template): Response
	{
		$this->data = new Text((new Render($template))->render());

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
			\header($headerKey . ': ' . $header, false);
		}

		foreach ($this->cookies as $cookie) {
			Cookie::create()->set($cookie['name'], $cookie['value'], $cookie['path'], $cookie['expire'], $cookie['domain']);
		}

		return true;
	}

	/**
	 * @param string $url
	 */
	public function redirect(string $url): void
	{
		\header('Location: ' . $url);
		exit;
	}

	/**
	 * @param string $routerName
	 * @param array $arguments
	 * @param int $status
	 * @throws \ES\Kernel\Exception\FileException
	 * @throws \ES\Kernel\Exception\KernelException
	 */
	public function redirectToRoute(string $routerName, array $arguments, int $status): void
	{
		$router = Routing::getRouterList()->get($routerName);

		if (!empty($router)) {
			$url = URL . Routing::replaceRegexToParam($router->getPath(), $router->getParam(), $arguments);
			\header('Location: ' . $url, true, $status);
			exit;
		}
	}
}