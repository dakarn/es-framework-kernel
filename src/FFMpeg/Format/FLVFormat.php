<?php
/**
 * Created by PhpStorm.
 * User: v.konovalov
 * Date: 28.05.2018
 * Time: 14:31
 */

namespace FFMpeg\Format;

use FFMpeg\FileFormatInterface;

class FLVFormat implements FileFormatInterface
{
	/**
	 * @var array
	 */
    private $data = [];

	/**
	 * FLVFormat constructor.
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