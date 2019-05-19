<?php
/**
 * Created by PhpStorm.
 * User: v.konovalov
 * Date: 28.05.2018
 * Time: 14:17
 */

namespace ES\Kernel\FFMpeg\Format;

use ES\Kernel\FFMpeg\FileFormatInterface;

class WEBMFormat implements FileFormatInterface
{
	/**
	 * @var array
	 */
    private $data = [];

	/**
	 * WEBMFormat constructor.
	 * @param array $data
	 */
    public function __construct(array $data)
    {
        $this->data = $data;
    }

	/**
	 * @return mixed|void
	 */
    public function save()
    {

    }
}