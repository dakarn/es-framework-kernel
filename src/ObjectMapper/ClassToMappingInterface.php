<?php
/**
 * Created by PhpStorm.
 * User: v.konovalov
 * Date: 12.04.2019
 * Time: 10:38
 */

namespace ObjectMapper;

interface ClassToMappingInterface
{
	/**
	 * @return array
	 */
	public function getProperties(): array;
}