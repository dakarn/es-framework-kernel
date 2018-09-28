<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 21.04.2018
 * Time: 19:27
 */

namespace Http\Response;

class Json implements FormatResponseInterface
{
	/**
	 * @var array
	 */
	private $data = [];

	/**
	 * Json constructor.
	 * @param array $data
	 */
	public function __construct(array $data)
	{
		$this->data = $data;
	}

	/**
	 * @return string
	 */
	public function getFormattedText(): string
	{
		return json_encode($this->data, JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES);
	}
}