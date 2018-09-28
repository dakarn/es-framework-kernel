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
	private $uri;

	public function __construct(string $uri)
	{
		$this->uri = $uri;
	}

	public function getUri()
	{
		return $this->uri;
	}

	public function withScheme()
	{

	}

	public function withPath()
	{

	}

	public function withPort()
	{

	}

	public function withHost()
	{

	}
}