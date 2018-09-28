<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 18.03.2018
 * Time: 1:54
 */

namespace Http\Request;

class Request implements RequestInterface
{
    /**
     * @var string
     */
    const
        POST    = 'POST',
        DELETE  = 'DELETE',
        PUT     = 'PUT',
        OPTIONS = 'OPTIONS',
        GET     = 'GET',
        PATCH   = 'PATCH',
        CONNECT = 'CONNECT';

    /**
     * @var array
     */
	protected $headers = [];

    /**
     * @var string
     */
	protected $method = '';

    /**
     * @var UriInterface
     */
    protected $uri;

    /**
     * @var string
     */
    protected $path = '';

    /**
     * @var string
     */
    protected $scheme = '';

    /**
     * @var array
     */
    protected $cookies = [];

    /**
     * @var string
     */
    protected $referer = '';

    /**
     * @var string
     */
    protected $userAgent = '';

    /**
     * @var string
     */
    protected $proxy = '';

    /**
     * @var string
     */
    protected $body = '';

	/**
	 * @return Request
	 */
	public static function create(): Request
	{
		return new static;
	}

	/**
	 * @return string
	 */
	public function getMethod(): string
	{
		return $this->method;
	}

	/**
	 * @return string
	 */
	public function getHost(): string
	{
		return $this->uri;
	}

	/**
	 * @return string
	 */
	public function getPath(): string
	{
		return $this->path;
	}

	/**
	 * @return string
	 */
	public function getReferer(): string
	{
		return $this->referer;
	}

	/**
	 * @return array
	 */
	public function getHeaders(): array
	{
		return $this->headers;
	}

	/**
	 * @return string
	 */
	public function getProxyServer(): string
	{
		return $this->proxy;
	}

	/**
	 * @return string
	 */
	public function getUserAgent(): string
	{
		return $this->userAgent;
	}

	/**
	 * @return string
	 */
	public function getBody(): string
	{
		return $this->body;
	}

	/**
	 * @return array
	 */
	public function getCookies(): array
	{
		return $this->cookies;
	}

	/**
	 * @return string
	 */
	public function getScheme(): string
	{
		return $this->scheme;
	}

    /**
     * @param string $method
     * @return Request
     */
	public function withMethod(string $method): self
	{
		$this->method = $method;
		return $this;
	}

    /**
     * @param UriInterface $uri
     * @return Request
     */
	public function withUri(UriInterface $uri): self
	{
		$this->uri = $uri->getUri();
		return $this;
	}

    /**
     * @param string $path
     * @return Request
     */
	public function withPath(string $path): self
	{
		$this->path = $path;
		return $this;
	}

    /**
     * @param string $name
     * @param string $value
     * @return Request
     */
	public function withHeader(string $name, string $value): self
	{
		$this->headers[$name] = $value;
		return $this;
	}

    /**
     * @param string $referer
     * @return Request
     */
	public function withReferer(string $referer): self
	{
		$this->referer = $referer;
		return $this;
	}

    /**
     * @param string $userAgent
     * @return Request
     */
	public function withUserAgent(string $userAgent): self
	{
		$this->userAgent = $userAgent;
		return $this;
	}

    /**
     * @param string $body
     * @return Request
     */
	public function withBody(string $body): self
	{
		$this->body = $body;
		return $this;
	}

    /**
     * @param array $fields
     * @return Request
     */
	public function withPostFields(array $fields): self
	{
		$this->body = $fields;
		return $this;
	}

    /**
     * @param string $proxy
     * @return Request
     */
	public function withProxyServer(string $proxy): self
	{
		$this->proxy = $proxy;
		return $this;
	}

    /**
     * @param string $scheme
     * @return Request
     */
	public function withScheme(string $scheme): self
	{
		$this->scheme = $scheme;
		return $this;
	}

    /**
     * @param array $cookies
     * @return Request
     */
	public function withCookie(array $cookies): self
	{
		$this->cookies[$cookies['name']] = $cookies['value'];
		return $this;
	}
}