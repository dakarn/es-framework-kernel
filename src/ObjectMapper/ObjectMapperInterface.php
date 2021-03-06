<?php
/**
 * Created by PhpStorm.
 * User: v.konovalov
 * Date: 12.04.2019
 * Time: 14:07
 */

namespace ES\Kernel\ObjectMapper;

use ES\Kernel\Exception\ObjectException;
use ES\Kernel\Helper\AbstractList;

interface ObjectMapperInterface
{
    /**
     * @param object $objectInput
     * @return array
     */
    public function objectToArray($objectInput): array;

    /**
     * @param $objectInput
     * @return string
     */
    public function objectToJson($objectInput): string;

    /**
     * @param AbstractList $objectList
     * @return string
     */
    public function objectListToJson(AbstractList $objectList);

    /**
     * @param array $arraysItems
     * @param string $objectInput
     * @param string $objectList
     * @return AbstractList
     */
    public function arraysToObjectList(array $arraysItems, $objectList, $objectInput = null): AbstractList;

	/**
	 * @param array $arrayData
	 * @param $objectInput
	 * @return mixed
	 */
    public function arrayToObject(array $arrayData, $objectInput);

    /**
     * @param array $arrayData
     * @return \stdClass
     */
    public function arrayToStdClass(array $arrayData): \stdClass;

    /**
     * @param \stdClass $stdClass
     * @return array
     */
    public function stdClassToArray(\stdClass $stdClass): array;
}