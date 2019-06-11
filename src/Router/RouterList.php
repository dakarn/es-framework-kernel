<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 19.03.2018
 * Time: 20:51
 */

namespace ES\Kernel\Router;

use ES\Kernel\Helper\AbstractList;

class RouterList extends AbstractList
{
    /**
     * @return string
     */
    public function getMappingClass(): string
    {
        return '';
    }
}