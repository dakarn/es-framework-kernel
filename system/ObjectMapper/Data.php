<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 15.04.2019
 * Time: 21:14
 */

namespace ObjectMapper;

class Data implements ClassToMappingInterface
{
	private $name;

	/**
	 * @return mixed
	 */
	public function getName()
	{
		return $this->name;
	}

	/**
	 * @param mixed $name
	 */
	public function setName($name): void
	{
		$this->name = $name;
	}
}