<?php

namespace ES\Kernel\UserManager;

use ES\Kernel\Helper\StorageHelper\AbstractStorage;

class UserStorage extends AbstractStorage
{
	public function packToObject($classToMapping)
	{
		parent::packToObject($classToMapping);
		return $this;
	}

	public function createUser()
    {

    }
}