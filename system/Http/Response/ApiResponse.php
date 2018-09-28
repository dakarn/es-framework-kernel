<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 28.03.2018
 * Time: 21:31
 */

namespace Http\Response;

class ApiResponse extends JsonResponse
{
	private $data;

	private $success = [
		'success' => true,
	];

	private $fail = [
		'success' => false,
	];

	public function render($data, array $param)
	{
		$this->data = $data;

		if ($param[0] === 'success') {
			$this->success();
		} else if ($param[0] === 'failed') {
			$this->fail();
		}

		parent::render($this->data, $param);
	}

	public function success(): void
	{
		$this->data = $this->success + $this->data;
	}

	public function fail(): void
	{
		$this->data = $this->fail + $this->data;
	}
}