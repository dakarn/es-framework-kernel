<?php
/**
 * Created by PhpStorm.
 * User: v.konovalov
 * Date: 24.04.2018
 * Time: 15:10
 */

namespace System\Database\ORM\Mapping;

interface ObjectMapperInterface
{
	/**
	 * @param array $arrayData
	 * @param string $objectInput
	 * @return mixed
	 */
    public function arrayToObject(array $arrayData, string $objectInput);

    /**
     * @param $object object
     * @return array
     */
    public function objectToArray($object): array;
}