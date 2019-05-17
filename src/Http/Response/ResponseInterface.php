<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 10.04.2018
 * Time: 22:59
 */

namespace Http\Response;

interface ResponseInterface
{
	/**
	 * @return Response
	 */
	public function output(): Response;

    /**
     * @return string
     */
    public function returnOutput(): string;

    /**
     * @return string
     */
    public function getStatusCode(): string;

    /**
	 * @return string
	 */
	public function getBody(): string;

    /**
     * @return string
     */
	public function getReasonPhrase(): string;

	/**
	 * @param FormatResponseInterface $formatted
	 * @return Response
	 */
	public function withBody(FormatResponseInterface $formatted): Response;

    /**
     * @param string $files
     * @return Response
     */
	public function withFiles(string $files): Response;

    /**
     * @param string $code
     * @param string $text
     * @return Response
     */
	public function withStatus(string $code, string $text): Response;

	/**
	 * @param string $name
	 * @param string $value
	 * @return Response
	 */
	public function withHeader(string $name, string $value): Response;

	/**
	 * @param string $name
	 * @param string $value
	 * @return Response
	 */
	public function withCookie(string $name, string $value): Response;

	/**
	 * @param string $template
	 * @return Response
	 */
	public function withTemplate(string $template): Response;

	/**
	 * @return bool
	 */
	public function sendHeaders(): bool;

	/**
	 * @param string $url
	 */
	public function redirect(string $url): void;

	/**
	 * @param string $routerName
	 * @param array $arguments
	 * @param int $status
	 */
	public function redirectToRoute(string $routerName, array $arguments, int $status): void;
}