<?php

namespace ES\Kernel\Helper\StorageHelper;

use ES\Kernel\Database\Adapter\DBAdapter;
use ES\Kernel\Database\DB;
use ES\Kernel\Exception\FileException;

class EsFrameworkMySQLStorage extends AbstractStorage
{
    /**
     * @return DBAdapter
     * @throws FileException
     */
    protected function getConnection(): DBAdapter
    {
        return DB::getMySQL()->getESFramework();
    }
}