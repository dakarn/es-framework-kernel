<?php
/**
 * Created by PhpStorm.
 * User: v.konovalov
 * Date: 12.04.2019
 * Time: 14:07
 */

namespace ObjectMapper;

use Exception\ObjectException;
use Helper\AbstractList;

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
    public function arraysToObjectList(array $arraysItems, string $objectInput, string $objectList): AbstractList;

    /**
     * @param array $arrayData
     * @param string $objectInput
     * @param ClassToMappingInterface|null $objectOutput
     * @return ClassToMappingInterface
     * @throws ObjectException
     */
    public function arrayToObject(array $arrayData, string $objectInput, ClassToMappingInterface $objectOutput = null);

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