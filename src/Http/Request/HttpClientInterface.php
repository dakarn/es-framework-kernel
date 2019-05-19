<?php
/**
 * Created by PhpStorm.
 * User: v.konovalov
 * Date: 23.04.2018
 * Time: 11:56
 */

namespace ES\Kernel\Http\Request;

use ES\Kernel\Http\Response\Response;

interface HttpClientInterface
{
	/**
	 * @param RequestInterface $request
	 * @return HttpClient
	 */
    public function sendRequest(RequestInterface $request): HttpClient;

    /**
     * @return Response
     */
    public function getResponse(): Response;

    /**
     * @return bool
     */
    public function isOK(): bool;

    /**
     * @return bool
     */
    public function isNotFound(): bool;
}