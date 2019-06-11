<?php

namespace ES\Kernel\UserManager;

use ES\Kernel\Helper\AbstractList;

class UserList extends AbstractList
{
    public function getMappingClass(): string
    {
       return User::class;
    }
}