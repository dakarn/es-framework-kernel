<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 21.04.2018
 * Time: 19:27
 */

namespace ES\Kernel\Http\Response;

class XML implements FormatResponseInterface
{
	/**
	 * @var array|string
	 */
	private $data = '';

	/**
	 * XML constructor.
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
		return $this->data;
	}
}