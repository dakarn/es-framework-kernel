<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 23.04.2018
 * Time: 20:07
 */

namespace ObjectMapper;

use Exception\ObjectException;
use Helper\AbstractList;
use Helper\Util;
use Traits\SingletonTrait;

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
        if (!\is_object($objectInput)) {
            throw new \InvalidArgumentException('');
        }

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
        $json = \json_encode($this->objectToArray($objectInput));

        if (json_last_error() > 0) {
            return '';
        }

        return $json;
    }

    /**
     * @param AbstractList $objectList
     * @return string
     */
    public function objectListToJson(AbstractList $objectList)
    {
        $array = [];

        foreach ($objectList->getAll() as $objectItem) {
            $array[] = $this->objectToArray($objectItem);
        }

        return \json_encode($array);
    }

	/**
	 * @param array $arraysItems
	 * @param string $objectInput
	 * @param string $objectList
	 * @return AbstractList
	 * @throws ObjectException
	 */
    public function arraysToObjectList(array $arraysItems, string $objectInput, string $objectList): AbstractList
    {
        /** @var AbstractList $objectListClass */
        $objectListClass = new $objectList();

        foreach ($arraysItems as $arrayItem) {
            $objectListClass->add($this->arrayToObject($arrayItem, $objectInput));
        }

        return $objectListClass;
    }

	/**
	 * @param array $arrayData
	 * @param string $objectInput
	 * @param ClassToMappingInterface|null $objectOutput
	 * @return ClassToMappingInterface
	 * @throws ObjectException
	 */
    public function arrayToObject(array $arrayData, string $objectInput, ClassToMappingInterface $objectOutput = null)
    {
        if (!$objectInput instanceof ClassToMappingInterface) {
            //throw ObjectException::notFound([$objectInput]);
        }

        if (empty($objectOutput)) {
            $objectOutput = new $objectInput();
        }

        foreach ($arrayData as $property => $itemValue) {

            $setMethodName = self::SETTER . \ucfirst($property);
            $getMethodName = self::GETTER . \ucfirst($property);

            if ($objectOutput->$getMethodName() instanceof ClassToMappingInterface) {
                $this->arrayToObject($itemValue, $property, $objectOutput->$getMethodName());
            } else if ($objectOutput->$getMethodName() instanceof AbstractList) {
                $this->arraysToObjectList($itemValue, $objectOutput->$getMethodName()->getMappingClass(), $objectOutput->$getMethodName());
            } else {
                $objectOutput->$setMethodName($itemValue);
            }
        }

	    if ($objectInput instanceof HasJsonPropertyInterface) {
		    $this->arrayToObject(
			    \json_decode($arrayData[$objectInput->getJsonProperty()]),
			    self::GETTER . \ucfirst($objectInput->getJsonProperty())
		    );
	    }

        return $objectOutput;
    }

	/**
	 * @param array $arrayData
	 * @return \stdClass
	 */
    public function arrayToStdClass(array $arrayData): \stdClass
    {
		return \json_decode(\json_encode($arrayData));
    }

	/**
	 * @param \stdClass $stdClass
	 * @return array
	 */
    public function stdClassToArray(\stdClass $stdClass): array
    {
        return \json_decode(\json_encode($stdClass), true);
    }
}