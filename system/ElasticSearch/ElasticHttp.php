<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 09.03.2018
 * Time: 1:01
 */

namespace ElasticSearch;

use ElasticSearch\ElasticResult;
use Exception\HttpException;
use System\Config;

class ElasticHttp
{
	const ALLOW_METHOD = [
		'POST'   => '',
		'PUT'    => '',
		'GET'    => '',
		'DELETE' => '',
		'HEAD'   => '',
	];

	private $isPretty = false;

	private $isGet = false;

	private $isSearch = false;

	private $url = '';

	private $isPost = false;

	private $isPut = false;

	private $isDelete = false;

	private $query = [];

	public function setPretty(bool $isPretty): self
	{
		$this->isPretty = $isPretty;
		return $this;
	}

	public function setGET()
	{
		$this->isGet    = true;
		$this->isSearch = false;
		$this->isPost   = false;
		$this->isPut    = false;
	}

	public function setPOST()
	{
		$this->isGet    = false;
		$this->isSearch = false;
		$this->isPost   = true;
		$this->isPut    = false;
	}

	public function setDELETE()
	{
		$this->isGet    = false;
		$this->isSearch = false;
		$this->isPost   = false;
		$this->isPut    = false;
		$this->isDelete = true;
	}

	public function setPUT()
	{
		$this->isGet    = false;
		$this->isSearch = false;
		$this->isPost   = false;
		$this->isPut    = true;
	}

	public function setSearch()
	{
		$this->isSearch = true;
		$this->isGet    = false;
	}

	public function query(array $query): ElasticResult
	{
		$result = $this->doRequest($query);

		if (empty($result)) {
			throw new HttpException('Unable to connect with Elastic Search!');
		}

		return (new ElasticResult($result));
	}

	private function doRequest(array $query): string
	{
		$config      = Config::get('elasticsearch');
		$urlRoot     = $config['schema'] . '://' . $config['host'] . ':' . $config['port'] . '/';
		$this->query = $query;

		$this->buildUri($urlRoot);

		$ch = curl_init($this->url);
		curl_setopt($ch, CURLOPT_TIMEOUT, 5 );

		if (is_array($query['body'])) {
			$query['body'] = json_encode($query['body'],  JSON_UNESCAPED_UNICODE);
		}

		if ($this->isPost) {
			curl_setopt($ch, CURLOPT_POST, true);
			curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-type: application/json']);
			curl_setopt($ch, CURLOPT_POSTFIELDS, $query['body']);
		} else if ($this->isPut) {
			curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PUT');
			curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-type: application/json']);
			curl_setopt($ch, CURLOPT_POSTFIELDS, $query['body']);
		} else if ($this->isDelete) {
			curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'DELETE');
		}

		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$result = curl_exec($ch);
		curl_close($ch);

		return $result;
	}

	private function buildUri(string $urlRoot)
	{
		if ($this->isSearch) {

			$this->isPost = true;
			$this->url = $urlRoot . $this->query['index'] . '/' . $this->query['type'] . '/_search/?';

		} else if ($this->isGet) {

			$this->url = $urlRoot . $this->query['index'] . '/' . $this->query['type'] . '/' . $this->query['id'];

		} else if ($this->isPut) {

			if (isset($this->query['id'])) {
				$this->url = $urlRoot . $this->query['index'] . '/' . $this->query['type'] . '/' . $this->query['id'];
			} else {
				$this->url = $urlRoot . $this->query['index'];
			}

		} else if ($this->isPost) {

			if (!empty($this->query['type'])) {
				$this->url = $urlRoot . $this->query['index'] . '/' . $this->query['type'] . '/' . $this->query['id'];
			} else {
				$this->url = $urlRoot . (!empty($this->query['index']) ?: $this->query['path']);
			}

		} else if ($this->isDelete) {

			if (isset($this->query['id'])) {
				$this->url = $urlRoot . $this->query['index'] . '/' . $this->query['type'] . '/' . $this->query['id'];
			} else {
				$this->url = $urlRoot . $this->query['index'];
			}
		}
	}
}