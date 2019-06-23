<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 23.06.2019
 * Time: 18:34
 */

namespace ES\Kernel\Helper\StorageHelper;

use ES\Kernel\ObjectMapper\ClassToMappingInterface;

abstract class AbstractStorage
{
	protected $classToMapping;

	/**
	 * @param $classToMapping ClassToMappingInterface|string
	 * @return $this
	 */
	public function packToObject($classToMapping)
	{
		if (\is_string($classToMapping)) {
			$this->classToMapping = new $classToMapping();
		}

		if (!$classToMapping instanceof ClassToMappingInterface) {
			throw new \RuntimeException('Object must be implements interface ClassToMappingInterface');
		}

		return $this;
	}
}