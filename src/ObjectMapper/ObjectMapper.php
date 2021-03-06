<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 23.04.2018
 * Time: 20:07
 */

namespace ES\Kernel\ObjectMapper;

use ES\Kernel\Exception\ObjectException;
use ES\Kernel\Helper\AbstractList;
use ES\Kernel\Helper\Util;
use ES\Kernel\Traits\SingletonTrait;

class ObjectMapper implements ObjectMapperInterface
{
    use SingletonTrait;

    /**
     * @var string
     */
    private const SETTER = 'set';

    /**
     * @var string
     */
    private const GETTER = 'get';

	/**
	 * @param object $objectInput
	 * @return array
	 */
    public function objectToArray($objectInput): array
    {
        if (\is_string($objectInput)) {
	        $objectInput = new $objectInput();
        }

        $this->verifyInterface($objectInput);

        $response = [];
        $methods  = \get_class_methods($objectInput);

        foreach ($methods as $indexMethod => $getMethodName) {

            if (\substr($getMethodName, 0, 3) === self::GETTER) {

                $property = \lcfirst(\substr($getMethodName, 3));

                if ($objectInput->$getMethodName() instanceof ClassToMappingInterface) {
                    $response[$property] = $this->objectToArray($objectInput->$getMethodName());
                } else if ($objectInput->$getMethodName() instanceof AbstractList) {
                    foreach ($objectInput->$getMethodName()->getAll() as $item) {
                        $response[$property][] = $this->objectToArray($item);
                    }
                } else {
                    $response[$property] = $objectInput->$getMethodName();
                }
            }
        }

       return $response;
    }

    /**
     * @param $objectInput
     * @return string
     */
    public function objectToJson($objectInput): string
    {
        return Util::jsonEncode($objectInput);
    }

    /**
     * @param AbstractList $objectList
     * @return false|string
     */
    public function objectListToJson(AbstractList $objectList): string
    {
        $array = [];

        foreach ($objectList->getAll() as $objectItem) {
            $array[] = $this->objectToArray($objectItem);
        }

        return Util::jsonEncode($array);
    }

	/**
	 * @param AbstractList $objectList
	 * @return array
	 */
	public function objectListToArrays(AbstractList $objectList): array
    {
        $array = [];

        foreach ($objectList->getAll() as $objectItem) {
            $array[] = $this->objectToArray($objectItem);
        }

        return $array;
    }

	/**
	 * @param array $arraysItems
	 * @param  ClassToMappingInterface|string $objectInput
	 * @param string $objectList
	 * @return AbstractList
	 * @throws ObjectException
	 */
    public function arraysToObjectList(array $arraysItems, $objectList, $objectInput = null): AbstractList
    {
	    if (\is_string($objectList)) {
	    	/** @var AbstractList $objectList */
		    $objectList = new $objectList();
	    }

	    if (empty($objectInput)) {
	    	$objectInput = $objectList->getMappingClass();
	    }

        foreach ($arraysItems as $arrayItem) {
	        $objectList->add($this->arrayToObject($arrayItem, $objectInput));
        }

        return $objectList;
    }

	/**
	 * @param array $arrayData
	 * @param $objectInput ClassToMappingInterface|string
	 * @return mixed
	 * @throws ObjectException
	 */
    public function arrayToObject(array $arrayData, $objectInput)
    {
        if (\is_string($objectInput)) {
        	$objectInput = new $objectInput();
        }

        $this->verifyInterface($objectInput);

        foreach ($arrayData as $property => $itemValue) {

        	$underIndex = strpos($property, '_');

        	if ($underIndex === 0) {
        		$property = substr($property, 1);
	        }
	        if ($underIndex > 0) {
        		$property = substr($property, 0, $underIndex) . ucfirst(substr($property, $underIndex + 1));
	        }

            $setMethodName = self::SETTER . \ucfirst($property);
            $getMethodName = self::GETTER . \ucfirst($property);

	        if ($objectInput->$getMethodName() instanceof ClassToMappingInterface) {
                if ($objectInput->$getMethodName() instanceof JsonPropertiesInterface) {
                    $this->arrayToObject(Util::jsonDecode($itemValue), $objectInput->$getMethodName());
                } else {
                    $this->arrayToObject($itemValue, $objectInput->$getMethodName());
                }
            } else if ($objectInput->$getMethodName() instanceof AbstractList) {
                $this->arraysToObjectList($itemValue, $objectInput->$getMethodName(), $objectInput->$getMethodName()->getMappingClass());
            } else {
            	if (in_array($property, $objectInput->getProperties())) {
		            $objectInput->$setMethodName($itemValue);
	            }
            }
        }

        return $objectInput;
    }

    /**
     * @param array $arrayData
     * @return \stdClass
     */
    public function arrayToStdClass(array $arrayData): \stdClass
    {
		return Util::jsonDecode(Util::jsonEncode($arrayData));
    }

    /**
     * @param \stdClass $stdClass
     * @return array
     */
    public function stdClassToArray(\stdClass $stdClass): array
    {
        return Util::jsonDecode(Util::jsonEncode($stdClass));
    }

    /**
     * @param $object
     */
    private function verifyInterface($object)
    {
        if (!$object instanceof ClassToMappingInterface) {
            throw new \InvalidArgumentException('Class must be implements from ClassToMappingInterface');
        }
    }
}