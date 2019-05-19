<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 10.04.2018
 * Time: 22:30
 */

namespace ES\Kernel\Http\Request;

interface RequestInterface
{
    /**
     * @return Request
     */
    public static function create(): Request;

    /**
     * @return string
     */
    public function getMethod(): string;

    /**
     * @return string
     */
    public function getHost(): string;

    /**
     * @return string
     */
    public function getBody(): string;

    /**
     * @return string
     */
    public function getPath(): string;

    /**
     * @return string
     */
    public function getReferer(): string;

    /**
     * @return array
     */
    public function getHeaders(): array;

    /**
     * @return string
     */
    public function getProxyServer(): string;

    /**
     * @return string
     */
    public function getUserAgent(): string;

    /**
     * @return array
     */
    public function getCookies(): array;

    /**
     * @return string
     */
    public function getScheme(): string;

    /**
     * @param string $method
     * @return Request
     */
    public function withMethod(string $method): Request;

    /**
     * @param UriInterface $uri
     * @return Request
     */
    public function withUri(UriInterface $uri): Request;

    /**
     * @param string $path
     * @return Request
     */
    public function withPath(string $path): Request;

    /**
     * @param string $name
     * @param string $value
     * @return Request
     */
    public function withHeader(string $name, string $value): Request;

    /**
     * @param string $referer
     * @return Request
     */
    public function withReferer(string $referer): Request;

    /**
     * @param string $userAgent
     * @return Request
     */
    public function withUserAgent(string $userAgent): Request;

    /**
     * @param string $body
     * @return Request
     */
    public function withBody(string $body): Request;

    /**
     * @param array $fields
     * @return Request
     */
    public function withPostFields(array $fields): Request;

    /**
     * @param string $proxy
     * @return Request
     */
    public function withProxyServer(string $proxy): Request;

    /**
     * @param string $scheme
     * @return Request
     */
    public function withScheme(string $scheme): Request;

    /**
     * @param array $cookies
     * @return Request
     */
    public function withCookie(array $cookies): Request;
}