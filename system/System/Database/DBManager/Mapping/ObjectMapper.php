<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 23.04.2018
 * Time: 20:07
 */

namespace System\Database\DBManager\Mapping;

use Exception\ObjectException;
use Psr\Log\InvalidArgumentException;
use Traits\SingletonTrait;

class ObjectMapper implements ObjectMapperInterface
{
    use SingletonTrait;

    /**
     * @var string
     */
    const SETTER = 'set';

    /**
     * @var string
     */
    const GETTER = 'get';

    /**
     * @param object $object
     * @return array
     */
    public function toArray($object): array
    {
        if (!is_object($object)) {
            throw new InvalidArgumentException('');
        }

        $response = [];
        $methods  = get_class_methods($object);

        foreach ($methods as $indexMethod => $getMethodName) {
            if (substr($getMethodName, 0, 3) === self::GETTER) {
                $property            = lcfirst(substr($getMethodName, 3));
                $response[$property] = $object->$getMethodName();
            }
        }

       return $response;
    }

	/**
	 * @param array $arrayData
	 * @param string $objectInput
	 * @return mixed
	 * @throws ObjectException
	 */
    public function toObject(array $arrayData, string $objectInput)
    {
        if (!is_array($arrayData) || empty($arrayData)) {
            throw new InvalidArgumentException('');
        }

	    if (!class_exists($objectInput)) {
		    throw ObjectException::notFound([$objectInput]);
	    }

        $objectOutput = new $objectInput();

        foreach ($arrayData as $property => $itemValue) {

            $setMethodName = self::SETTER . ucfirst($property);

            if (method_exists($objectInput, $setMethodName)) {
                $objectOutput->$setMethodName($itemValue);
            }
        }

        return $objectOutput;
    }
}