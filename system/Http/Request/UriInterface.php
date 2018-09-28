<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 17.04.2018
 * Time: 20:50
 */

namespace Http\Request;

interface UriInterface
{
    /**
     * @return string
     */
    public function getUri(): string;

    /**
     * @return string
     */
    public function getScheme(): string;

    /**
     * @return string
     */
    public function getAuthority(): string;

    /**
     * @return string
     */
    public function getHost(): string;

    /**
     * @return string
     */
    public function getFragment(): string;

    /**
     * @return string
     */
    public function getPort(): string;

    /**
     * @return string
     */
    public function getQuery(): string;

    /**
     * @return string
     */
    public function getPath(): string;

    /**
     * @param string $scheme
     * @return UriInterface
     */
    public function withScheme(string $scheme): UriInterface;

    /**
     * @param string $url
     * @return UriInterface
     */
    public function withHost(string $url): UriInterface;

    /**
     * @param string $query
     * @return UriInterface
     */
    public function withQuery(string $query): UriInterface;

    /**
     * @param string $path
     * @return UriInterface
     */
    public function withPath(string $path): UriInterface;

    /**
     * @param string $port
     * @return UriInterface
     */
    public function withPort(string $port): UriInterface;

    /**
     * @param string $uri
     * @return UriInterface
     */
    public function withUri(string $uri): UriInterface;

    /**
     * @param string $fragment
     * @return UriInterface
     */
    public function withFragment(string $fragment): UriInterface;

    /**
     * @return mixed
     */
    public function __toString();

    /**
     * @param string $queryString
     * @return UriInterface
     */
    public function withQueryString(string $queryString): UriInterface;

}