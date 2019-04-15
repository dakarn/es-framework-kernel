<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 15.04.2019
 * Time: 21:12
 */

namespace ObjectMapper;

class Test implements ClassToMappingInterface, HasJsonPropertyInterface
{
	private $data;

	public function __construct()
	{
		$this->data = new Data();
	}

	public function getJsonProperty(): string
	{
		return 'data';
	}

	/**
	 * @return mixed
	 */
	public function getData()
	{
		return $this->data;
	}

	/**
	 * @param mixed $data
	 */
	public function setData($data): void
	{
		$this->data = $data;
	}
}