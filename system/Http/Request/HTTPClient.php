<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 19.03.2018
 * Time: 21:27
 */

namespace Http\Request;

use Traits\SingletonTrait;

final class HTTPClient
{
	use SingletonTrait;

	private $headers = [];

	private $paramCurl = [];

	private $result;

	/** @var  Request */
	private $request;

	public function doRequest(Request $request)
	{
		$this->request = $request;

		$this->buildQuery();
		$this->execute();
	}

	private function buildQuery()
	{
		$this->headers          = $this->request->getHeaders();
		$this->paramCurl['url'] = $this->request->getHost();
	}

	private function execute()
	{
		$ch = curl_init($this->paramCurl['url']);
		$this->result = curl_exec($ch);
		curl_close($ch);
	}
}