<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 17.04.2018
 * Time: 20:48
 */

namespace Http\Request;

class Uri implements UriInterface
{
    /**
     * @var string
     */
	private $uri;

    /**
     * Uri constructor.
     * @param string $uri
     */
	public function __construct(string $uri)
	{
		$this->uri = $uri;
	}

    /**
     * @return string
     */
    public function getUri(): string
    {
        return $this->uri;
    }

    /**
     * @return string
     */
	public function getAuthority(): string
    {
       return $this->uri;
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
    public function getFragment(): string
    {
        return $this->uri;
    }

    /**
     * @return string
     */
    public function getPath(): string
    {
        return $this->uri;
    }

    /**
     * @return string
     */
    public function getPort(): string
    {
        return $this->uri;
    }

    /**
     * @return string
     */
    public function getQuery(): string
    {
        return $this->uri;
    }

    public function getScheme(): string
    {
        return $this->uri;
    }

    /**
     * @param string $fragment
     * @return UriInterface
     */
    public function withFragment(string $fragment): UriInterface
    {
        return $this;
    }

    /**
     * @param string $url
     * @return UriInterface
     */
    public function withHost(string $url): UriInterface
    {
        return $this;
    }

    /**
     * @param string $query
     * @return UriInterface
     */
    public function withQuery(string $query): UriInterface
    {
        return $this;
    }

    /**
     * @param string $scheme
     * @return UriInterface
     */
	public function withScheme(string $scheme): UriInterface
	{
	    $this->uri = $scheme;
        return $this;
	}

    /**
     * @param string $queryString
     * @return UriInterface
     */
	public function withQueryString(string $queryString): UriInterface
    {
        $this->uri = $queryString;
        return $this;
    }

    /**
     * @param string $path
     * @return UriInterface
     */
	public function withPath(string $path): UriInterface
	{
        $this->uri = $path;
        return $this;
	}

    /**
     * @param string $port
     * @return UriInterface
     */
	public function withPort(string $port): UriInterface
	{
        $this->uri = $port;
        return $this;
	}

    /**
     * @param string $uri
     * @return UriInterface
     */
	public function withUri(string $uri): UriInterface
	{
        $this->uri = $uri;
        return $this;
	}

    /**
     * @return string
     */
	public function __toString()
    {
       return $this->uri;
    }
}