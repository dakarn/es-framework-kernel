<?php

namespace ES\Kernel\UserManager;

use ES\Kernel\Helper\StorageHelper\EsFrameworkMySQLStorage;

class UserStorage extends EsFrameworkMySQLStorage
{
    protected function getObjectName()
    {
        return User::class;
    }

	public function createUser()
    {

    }
}