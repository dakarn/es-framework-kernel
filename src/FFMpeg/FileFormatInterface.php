<?php
/**
 * Created by PhpStorm.
 * User: v.konovalov
 * Date: 28.05.2018
 * Time: 14:35
 */

namespace ES\Kernel\FFMpeg;

interface FileFormatInterface
{
	/**
	 * @return mixed
	 */
    public function save();
}