<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 26.11.2018
 * Time: 22:13
 */

namespace ElasticSearchNew\Response;

class AbstractResponse
{
	protected $response = [];

	public function __construct(string $response)
	{
		$this->response = \json_decode($response, true);
	}
}