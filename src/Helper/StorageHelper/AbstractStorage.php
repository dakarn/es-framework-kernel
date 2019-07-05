<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 23.06.2019
 * Time: 18:34
 */

namespace ES\Kernel\Helper\StorageHelper;

use ES\Kernel\Database\Adapter\DBAdapter;
use ES\Kernel\Exception\ObjectException;
use ES\Kernel\Helper\AbstractList;
use ES\Kernel\ObjectMapper\ClassToMappingInterface;
use RuntimeException;

abstract class AbstractStorage
{
    /**
     * @param string $sql
     * @return ClassToMappingInterface
     * @throws ObjectException
     */
	protected function fetchRowToObject(string $sql): ClassToMappingInterface
    {
        return $this->getConnection()->fetchRowToObject($sql, $this->getObjectName());
    }

    /**
     * @param string $sql
     * @return AbstractList
     * @throws ObjectException
     */
    protected function fetchToObjectList(string $sql): AbstractList
    {
        return $this->getConnection()->fetchToObjectList($sql, $this->getObjectName());
    }

    /**
     * @return mixed
     */
	protected function getObjectName()
    {
        throw new RuntimeException('The method no use');
    }

    /**
     * @return mixed
     */
	protected function getObjectListName()
    {
        throw new RuntimeException('The method no use');
    }

    abstract protected function getConnection(): DBAdapter;
}