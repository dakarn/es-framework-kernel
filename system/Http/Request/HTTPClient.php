<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 19.03.2018
 * Time: 21:27
 */

namespace Http\Request;

use Http\Response\Response;
use Http\Response\Text;

final class HttpClient implements HttpClientInterface
{
    /**
     * @var resource
     */
    private $curl;

    /**
     * @var RequestBuilderInterface
     */
	private $requestBuilder;

	/**
	 * @var string
	 */
	private $result;

	/**
	 * @var Request
	 */
	private $request;

    /**
     * @param RequestInterface $request
     * @return HttpClient
     */
	public function sendRequest(RequestInterface $request): HttpClient
	{
		$this->request = $request;

		$this->buildQuery(new RequestBuilder($request));
		$this->execute();

		return $this;
	}

    /**
     * @return Response
     */
    public function getResponse(): Response
    {
        return (new Response())->withBody(new Text($this->result));
    }

    /**
     * @return bool
     */
	public function isOK(): bool
    {
        return $this->result !== false ? true : false;
    }

	/**
	 * @return string
	 */
    public function getStatusCode(): string
    {
    	return '';
    }

    /**
     * @return bool
     */
	public function isNotFound(): bool
    {
        return $this->result === false ? true : false;
    }

	/**
	 * @param RequestBuilderInterface $builder
	 */
	private function buildQuery(RequestBuilderInterface $builder): void
	{
	    $this->requestBuilder = $builder;
	}

	/**
	 * @varv oid
	 */
	private function execute(): void
	{
		$this->curl   = $this->requestBuilder->getBuilderData();
		$this->result = curl_exec($this->curl);
		curl_close($this->curl);
	}
}