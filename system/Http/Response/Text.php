<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 21.04.2018
 * Time: 19:28
 */

namespace Http\Response;

class Text implements FormatResponseInterface
{
	/**
	 * @var string
	 */
	private $data = '';

	/**
	 * Text constructor.
	 * @param string $data
	 */
	public function __construct(string $data)
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