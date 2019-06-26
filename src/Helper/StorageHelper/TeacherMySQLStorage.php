<?php

namespace ES\Kernel\Helper\StorageHelper;

use ES\Kernel\Database\Adapter\DBAdapter;
use ES\Kernel\Database\DB;

class TeacherMySQLStorage extends AbstractStorage
{
    /**
     * @return DBAdapter
     * @throws \Exception
     */
    protected function getConnection(): DBAdapter
    {
        return DB::getMySQL()->getTeacher();
    }
}