<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 21.04.2018
 * Time: 19:27
 */

namespace ES\Kernel\Http\Response;

class API implements FormatResponseInterface
{
	/**
	 * @var string
	 */
	const SUCCESS = 'success';
	const FAIL    = 'fail';

	/**
	 * @var array
	 */
	private $data = [];

	/**
	 * @var array
	 */
	private $params = [];

	/**
	 * @var array
	 */
	private $success = [
		'success' => true,
	];

	/**
	 * @var array
	 */
	private $failed = [
		'success' => false,
	];

	/**
	 * API constructor.
	 * @param array $data
	 * @param array $params
	 */
	public function __construct(array $data, array $params)
	{
		$this->data   = $data;
		$this->params = $params;
		
		if (!isset($this->params['type'])) {
			throw new \DomainException('Arguments invalid for class API Formatted. Unable use index of array "type"!');
		}
	}

	/**
	 * @return string
	 */
	public function getFormattedText(): string
	{
		if ($this->params['type'] === self::SUCCESS) {
			$this->success();
		} else if ($this->params['type'] === self::FAIL) {
			$this->failed();
		}

		return \json_encode($this->data, JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES);
	}

	/**
	 * @return void
	 */
	public function success(): void
	{
		$this->data = $this->success + ['data' => $this->data];
	}

	/**
	 * @return void
	 */
	public function failed(): void
	{
		$this->data = $this->failed + ['data' => $this->data];
	}
}